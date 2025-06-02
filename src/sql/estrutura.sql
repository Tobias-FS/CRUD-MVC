CREATE TABLE livro (
    id INT NOT NULL AUTO_INCREMENT,
    autor VARCHAR(100),
    ano INT,
    categoria VARCHAR(200),
    CONSTRAINT `pk_livro` 
        PRIMARY KEY ( id )
) ENGINE=InnoDB;