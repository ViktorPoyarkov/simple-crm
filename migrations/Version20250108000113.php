<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108000113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a stored procedure StopOutProcess to implement Stop Out logic';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            DELIMITER $$

            CREATE PROCEDURE StopOutProcess()
            BEGIN
                DECLARE done INT DEFAULT 0;
                DECLARE user_id INT;

                -- Cursor for users who fall under Stop Out
                DECLARE stop_out_cursor CURSOR FOR 
                SELECT e.user_id
                FROM (
                    WITH equity_calculation AS (
                        SELECT 
                            u.id AS user_id,
                            u.cash_balance,
                            COALESCE(SUM(t.pnl), 0) AS total_open_pnl,
                            COALESCE(SUM(t.used_margin), 0) AS total_used_margin,
                            (u.cash_balance + COALESCE(SUM(t.pnl), 0) + COALESCE(SUM(t.used_margin), 0)) AS equity
                        FROM 
                            users u
                        LEFT JOIN 
                            trades t ON u.id = t.user_id
                        GROUP BY 
                            u.id
                    )
                    SELECT 
                        e.user_id
                    FROM 
                        equity_calculation e,
                    WHERE 
                        (e.equity / e.total_used_margin) * 100 < 10
                ) stop_out_users;

                DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

                OPEN stop_out_cursor;

                -- Iteration trough users
                read_loop: LOOP
                    FETCH stop_out_cursor INTO user_id;
                    IF done THEN
                        LEAVE read_loop;
                    END IF;

                    -- Delete trades with larges size
                    DELETE FROM trades
                    WHERE id = (
                        SELECT id
                        FROM trades
                        WHERE user_id = user_id
                        ORDER BY size DESC
                        LIMIT 1
                    );

                    -- Recalculate cash_balance
                    UPDATE users u
                    SET cash_balance = cash_balance + (
                        SELECT pnl
                        FROM trades
                        WHERE user_id = u.id
                        ORDER BY size DESC
                        LIMIT 1
                    )
                    WHERE id = user_id;
                END LOOP;

                CLOSE stop_out_cursor;
            END$$

            DELIMITER ;
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP PROCEDURE IF EXISTS StopOutProcess;");
    }
}
