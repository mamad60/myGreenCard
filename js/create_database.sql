# Create schemas
# Create tables
CREATE TABLE IF NOT EXISTS Applicant
(
    ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
    FirstName_fa VARCHAR(33) ,
    LastName_fa VARCHAR(33) ,
    FirstName_en VARCHAR(33) ,
    LastName_en VARCHAR(33) ,
    Gender ENUM('male','female') ,
    BirthDate VARCHAR(10) ,
    BirthDate_Georgian VARCHAR(10) ,
    BirthCity VARCHAR(33) ,
    BirthCountry VARCHAR(33) ,
    Address VARCHAR(60) ,
    ZipCode VARCHAR(16),
    TelNumber INT(12) ,
    Education ENUM('Primary','Some Highschool','Vaccany','Highschool','2 years University','Bachelor','Master','PhD') ,
    ChildNumber INT(2) ,
    Email VARCHAR(33),
    MaridgStatus ENUM('Single','Married','Married Spouse US citizen','Divorced','widowed') ,
    hasSpouse BOOLEAN,
    hasChildren BOOLEAN,
    TrackingCode VARCHAR(33),
    isPayed BOOLEAN
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Spouse

(
    ID INT(6) UNSIGNED  AUTO_INCREMENT PRIMARY KEY ,
    ApplicantID INT(6) UNSIGNED  NOT NULL ,
    FirstName_fa VARCHAR(33) ,
    LastName_fa VARCHAR(33) ,
    FirstName_en VARCHAR(33) ,
    LastName_en VARCHAR(33) ,
    Gender ENUM('male','female') ,
    BirthDate VARCHAR(10) ,
    BirthDate_Georgian VARCHAR(10) ,
    BirthCity VARCHAR(33) ,
    BirthCountry VARCHAR(33),
    INDEX ( ApplicantID ),
     FOREIGN KEY (ApplicantID)  REFERENCES Applicant(id)
     ON DELETE CASCADE ON UPDATE CASCADE    
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Children
(
    ID INT(6) UNSIGNED  AUTO_INCREMENT PRIMARY KEY ,
    ApplicantID INT(6) UNSIGNED  NOT NULL ,
    LastName_fa VARCHAR(33) ,
    FirstName_en VARCHAR(33) ,
    LastName_en VARCHAR(33) ,
    Gender ENUM('male','female') ,
    BirthDate VARCHAR(10) ,
    BirthDate_Georgian VARCHAR(10) ,
    BirthCity VARCHAR(33) ,
    BirthCountry VARCHAR(33),
    INDEX ( ApplicantID ),
    FOREIGN KEY (ApplicantID)  REFERENCES Applicant(id)
    ON DELETE CASCADE ON UPDATE CASCADE  
)ENGINE = InnoDB;     

