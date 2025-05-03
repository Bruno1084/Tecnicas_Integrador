use tecnicas_integrador_db;
create table users(
	id int not null auto_increment,
    name varchar(200) not null,
    nickname varchar(200) not null unique,
    email varchar(200) not null unique,
    password varchar(200) not null,
    active boolean not null,
    primary key(id)
);

create table tasks(
	id int not null auto_increment,
    subject varchar(200) not null,
    description varchar(500) not null,
    priority enum('alta', 'media', 'baja') not null,
    state enum('no iniciada', 'en proceso', 'completada') default 'no iniciada',    
    reminderDate Datetime,
    expirationDate Datetime,
    color varchar(45) not null,
    idAutor int not null,
    primary key (id),
    foreign key (idAutor) references users(id) 
    on delete cascade 
);

create table subtasks(
	id int not null auto_increment,
    description varchar(500) not null,
	priority enum('alta', 'media', 'baja'),
    state enum('no iniciada', 'en proceso', 'completada') default 'no iniciada',
    reminderDate Datetime,
    comment varchar(500),
    idResponsible int,
    idTask int not null,
    primary key(id),
	FOREIGN KEY (idResponsible) REFERENCES users(id)
		ON DELETE SET NULL,
	FOREIGN KEY (idTask) REFERENCES tasks(id)
		ON DELETE CASCADE
);