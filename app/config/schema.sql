CREATE TABLE IF NOT EXISTS statuses (
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	auteur int NOT NULL,
	commentaire varchar(140) NOT NULL,
	dateC DATETIME
);

CREATE TABLE IF NOT EXISTS users (
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name varchar(50) NOT NULL,
	password varchar(50) NOT NULL
)
