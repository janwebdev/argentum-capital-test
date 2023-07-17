# CREATE DATABASE STRUCTURE

CREATE DATABASE IF NOT EXISTS argentum_database;

CREATE TABLE IF NOT EXISTS `groups` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id));

CREATE TABLE IF NOT EXISTS users_in_groups (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_11 (user_id), INDEX IDX_12 (group_id), PRIMARY KEY(user_id, group_id));

CREATE TABLE IF NOT EXISTS group_permission (group_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_1 (group_id), INDEX IDX_2 (permission_id), PRIMARY KEY(group_id, permission_id));

CREATE TABLE IF NOT EXISTS permissions (id INT AUTO_INCREMENT NOT NULL, source VARCHAR(255) NOT NULL, INDEX user_source_perm_idx (source), INDEX group_source_perm_idx (source), PRIMARY KEY(id));

CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, INDEX username_idx (username), PRIMARY KEY(id));

CREATE TABLE IF NOT EXISTS user_permission (user_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_3 (user_id), INDEX IDX_4 (permission_id), PRIMARY KEY(user_id, permission_id));

ALTER TABLE group_permission ADD CONSTRAINT FK_1 FOREIGN KEY (group_id) REFERENCES `groups` (id) ON DELETE CASCADE;

ALTER TABLE group_permission ADD CONSTRAINT FK_2 FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE;

ALTER TABLE user_permission ADD CONSTRAINT FK_3 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE;

ALTER TABLE user_permission ADD CONSTRAINT FK_4 FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE;

# LOAD DEMO DATA

INSERT INTO users (username) VALUES ('admin');
INSERT INTO users (username) VALUES ('programmer');
INSERT INTO users (username) VALUES ('manager');

INSERT INTO `groups` (name) VALUES ('administrators');
INSERT INTO `groups` (name) VALUES ('developers');
INSERT INTO `groups` (name) VALUES ('managers');

INSERT INTO users_in_groups (user_id, group_id) VALUES (1,1);
INSERT INTO users_in_groups (user_id, group_id) VALUES (2,2);
INSERT INTO users_in_groups (user_id, group_id) VALUES (3,3);

INSERT INTO permissions (source) VALUES ('ModuleOne::ModuleOneFunctionOne');
INSERT INTO permissions (source) VALUES ('ModuleOne::ModuleOneFunctionTwo');
INSERT INTO permissions (source) VALUES ('ModuleOne::ModuleOneFunctionThree');
INSERT INTO permissions (source) VALUES ('ModuleTwo');
INSERT INTO permissions (source) VALUES ('ModuleThree::ModuleThreeFunctionTwo');
INSERT INTO group_permission (group_id, permission_id) VALUES (1, 1);
INSERT INTO group_permission (group_id, permission_id) VALUES (1, 2);
INSERT INTO group_permission (group_id, permission_id) VALUES (1, 3);
INSERT INTO group_permission (group_id, permission_id) VALUES (1, 4);
INSERT INTO group_permission (group_id, permission_id) VALUES (1, 5);

INSERT INTO permissions (source) VALUES ('ModuleOne');
INSERT INTO permissions (source) VALUES ('ModuleTwo::ModuleThreeFunctionOne');
INSERT INTO permissions (source) VALUES ('ModuleTwo::ModuleThreeFunctionTwo');
INSERT INTO group_permission (group_id, permission_id) VALUES (2, 6);
INSERT INTO group_permission (group_id, permission_id) VALUES (2, 7);
INSERT INTO group_permission (group_id, permission_id) VALUES (2, 8);

INSERT INTO permissions (source) VALUES ('ModuleOne::ModuleOneFunctionOne');
INSERT INTO permissions (source) VALUES ('ModuleOne::ModuleOneFunctionThree');
INSERT INTO permissions (source) VALUES ('ModuleThree::ModuleThreeFunctionOne');
INSERT INTO permissions (source) VALUES ('ModuleThree::ModuleThreeFunctionThree');
INSERT INTO group_permission (group_id, permission_id) VALUES (3, 9);
INSERT INTO group_permission (group_id, permission_id) VALUES (3, 10);
INSERT INTO user_permission (user_id, permission_id) VALUES (3, 11);
INSERT INTO user_permission (user_id, permission_id) VALUES (3, 12);