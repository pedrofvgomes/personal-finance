drop table if exists Account;
drop table if exists Expense;
drop table if exists Income;
drop table if exists Category;
drop table if exists Goal;
drop table if exists Saving;

create table Account(
    id integer not null primary key autoincrement,
    username varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    name varchar(255),
    balance integer
    datecreated timestamp default current_timestamp
);

create table Expense(
    id integer not null primary key autoincrement,
    user integer not null references Account(id),
    amount integer not null,
    category integer references Category(id),
    date timestamp default current_timestamp
);

create table Income(
    id integer not null primary key autoincrement,
    user integer not null references Account(id),
    amount integer not null,
    category integer references Category(id),
    description varchar(255),
    date timestamp default current_timestamp
);

create table Category(
    id integer not null primary key autoincrement,
    name varchar(255) not null
);

create table Goal(
    id integer not null primary key autoincrement,
    name varchar(255) not null,
    amount integer not null
);

create table Saving(
    id integer not null primary key autoincrement,
    goal integer not null references Goal(id),
    amount integer not null
);

INSERT INTO Category (name) VALUES ('Food'), ('Education'), ('Transportation'), ('Health'), ('Entertainment'), ('House');
