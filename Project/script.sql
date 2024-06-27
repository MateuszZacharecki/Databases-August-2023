drop table if exists Service;
drop table if exists Performance;
drop table if exists Announcement;
drop table if exists Composition;
drop table if exists Pianist;

-- Table: Announcement
CREATE TABLE Announcement (
    title varchar(50)  PRIMARY KEY,
    deadline timestamp
);

-- Table: Composition
CREATE TABLE Composition (
    ID serial  PRIMARY KEY,
    author varchar(30),
    title varchar(50)  NOT NULL,
    UNIQUE(author, title) 
);

-- Table: Pianist
CREATE TABLE Pianist (
    ID serial  PRIMARY KEY,
    first_name varchar(15)  NOT NULL,
    last_name varchar(20)  NOT NULL,
    UNIQUE(first_name, last_name)
);

-- Table: Performance
CREATE TABLE Performance (
    which_one int,
    ID serial  PRIMARY KEY,
    Pianist_ID int  NOT NULL,
    Composition_ID int  NOT NULL,
    note float,
    FOREIGN KEY (Pianist_ID) REFERENCES Pianist(ID),
    FOREIGN KEY (Composition_ID) REFERENCES Composition(ID),
    CHECK (note >= 0.0 AND note <= 6.0),
    UNIQUE(which_one)
);

-- Table: Service
CREATE TABLE Service (
    login varchar(15)  PRIMARY KEY,
    password varchar(20)  NOT NULL
);

insert into Service(login, password) values ('admin','haslo123');

grant select on Service to scott;
grant insert on Announcement to scott;
grant select on Announcement to scott;
grant insert on Composition to scott;
grant usage, select on sequence composition_id_seq to scott;
grant usage, select on sequence pianist_id_seq to scott;
grant usage, select on sequence performance_id_seq to scott;
grant insert on Pianist to scott;
grant select on Pianist to scott;
grant select on Composition to scott;
grant insert on Performance to scott;
grant select on Performance to scott;
grant update on Performance to scott;
