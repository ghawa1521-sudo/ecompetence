<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20260921104941 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on mysql.'
        );

        $this->addSql(
            'UPDATE agent_emploi ae
             INNER JOIN agent a ON a.matricule = ae.agent_id
             SET ae.agent_id = a.id'
        );
        $this->addSql(
            'UPDATE agent_fonction af
             INNER JOIN agent a ON a.matricule = af.agent_id
             SET af.agent_id = a.id'
        );

        $this->addSql(
            'ALTER TABLE agent_emploi DROP FOREIGN KEY FK_2A47E7DC3414710B'
        );
        $this->addSql(
            'ALTER TABLE agent_emploi MODIFY agent_id INT DEFAULT NULL'
        );
        $this->addSql(
            'ALTER TABLE agent_emploi ADD CONSTRAINT FK_2A47E7DC3414710B
             FOREIGN KEY (agent_id) REFERENCES agent (id)'
        );

        $this->addSql(
            'ALTER TABLE agent_fonction DROP FOREIGN KEY FK_3FD1CC293414710B'
        );
        $this->addSql(
            'ALTER TABLE agent_fonction MODIFY agent_id INT DEFAULT NULL'
        );
        $this->addSql(
            'ALTER TABLE agent_fonction ADD CONSTRAINT FK_3FD1CC293414710B
             FOREIGN KEY (agent_id) REFERENCES agent (id)'
        );
    }

    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on mysql.'
        );

        $this->addSql(
            'ALTER TABLE agent_emploi DROP FOREIGN KEY FK_2A47E7DC3414710B'
        );
        $this->addSql(
            'ALTER TABLE agent_emploi MODIFY agent_id VARCHAR(255) DEFAULT NULL'
        );
        $this->addSql(
            'UPDATE agent_emploi ae
             INNER JOIN agent a ON a.id = CAST(ae.agent_id AS UNSIGNED)
             SET ae.agent_id = a.matricule'
        );
        $this->addSql(
            'ALTER TABLE agent_emploi ADD CONSTRAINT FK_2A47E7DC3414710B
             FOREIGN KEY (agent_id) REFERENCES agent (matricule)'
        );

        $this->addSql(
            'ALTER TABLE agent_fonction DROP FOREIGN KEY FK_3FD1CC293414710B'
        );
        $this->addSql(
            'ALTER TABLE agent_fonction MODIFY agent_id VARCHAR(255) DEFAULT NULL'
        );
        $this->addSql(
            'UPDATE agent_fonction af
             INNER JOIN agent a ON a.id = CAST(af.agent_id AS UNSIGNED)
             SET af.agent_id = a.matricule'
        );
        $this->addSql(
            'ALTER TABLE agent_fonction ADD CONSTRAINT FK_3FD1CC293414710B
             FOREIGN KEY (agent_id) REFERENCES agent (matricule)'
        );
    }
}