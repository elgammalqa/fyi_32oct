Create database fyi_arabic;
use fyi_arabic;  
 
CREATE TABLE `users` (
  `Email` varchar(50) NOT NULL primary key,
  `First_name` varchar(50) NOT NULL,
  `Last_name` varchar(50) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Photo` varchar(250) NOT NULL,
  `Password` varchar(500) NOT NULL,
  `Function` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `isEmailConfirmed` tinyint(4) NOT NULL,
  `token` varchar(10) COLLATE utf8_unicode_ci NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
insert into users values("123@chatsrun.com","Admin","Admin","Male","1.png","$2y$10$ri8gecwi4ceBpDwW2g47XOGtdVzWF0eDNxb91UxjAQZ9MwC6Hfboi","Admin",0,1,'');
 
CREATE TABLE `news` (
  `id` int(255) NOT NULL AUTO_INCREMENT primary key,
  `title` text NOT NULL,
  `description` longtext NULL,
  `type` varchar(50) NOT NULL,
  `media` tinytext  NULL,
  `content` longtext  NULL,
  `pubDate` datetime NOT NULL,
  `employee` varchar(50) NOT NULL,   
  `status` int(50) NOT NULL DEFAULT '0',
  `thumbnail` text  NULL,
  FOREIGN KEY (employee) REFERENCES users(Email) on DELETE CASCADE on UPDATE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `news_published` (
  `id` int(255) NOT NULL AUTO_INCREMENT primary key,
  `title` text NOT NULL,
  `description` longtext NULL,
  `type` varchar(50) NOT NULL,
  `media` tinytext  NULL,
  `content` longtext  NULL,
  `pubDate` datetime NOT NULL,
  `employee` varchar(50) NOT NULL,
  `status` int(50) NOT NULL DEFAULT '1',
  `thumbnail` text  NULL,
  FOREIGN KEY (employee) REFERENCES users(Email) on DELETE CASCADE on UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 
CREATE TABLE `ads` (
  `id` int(255) NOT NULL AUTO_INCREMENT primary key,
  `title` text NOT NULL,
  `description` longtext NULL, 
  `media` tinytext  NULL,
  `pdf` tinytext  NULL,
  `content` longtext  NULL,
  `pubDate` datetime NOT NULL,
  `finDate` int NOT NULL,
  `employee` varchar(50) NOT NULL,
  `thumbnail` text  NULL,
  FOREIGN KEY (employee) REFERENCES users(Email) on DELETE CASCADE on UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 



 


CREATE TABLE `utilisateurs` (
  `email` varchar(50) NOT NULL  primary key,
  `name` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `isEmailConfirmed` tinyint(4) NOT NULL,
  `token` varchar(10) COLLATE utf8_unicode_ci NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 



CREATE TABLE comments(
`id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_news int(255) not null ,
    email_user varchar(50) not null, 
    FOREIGN key(id_news) REFERENCES news_published(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE  

)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE replies(
`id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_news int(255) not null ,
    email_user varchar(50) not null,
    id_comment int(255) not null,
    FOREIGN key(id_news) REFERENCES news_published(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(id_comment) REFERENCES comments(id) on DELETE CASCADE on UPDATE CASCADE 

)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE report(id int(255) not null AUTO_INCREMENT PRIMARY key,
                    id_news int(255) not null,
                    email_user_report varchar(50) not null,
                    email_user_abuse varchar(50) not null,
                    id_comment int(255) null,
                    id_reply int(255) null,
                    date_report datetime not null,
                    type varchar(50) not null,
                    other longtext null ,
                    FOREIGN KEY(id_news) REFERENCES news_published(id) on DELETE CASCADE on UPDATE CASCADE,
                    FOREIGN KEY(email_user_report) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE,
                    FOREIGN KEY(email_user_abuse) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE,
                    FOREIGN KEY(id_comment) REFERENCES comments(id) on DELETE CASCADE on UPDATE CASCADE ,
                    FOREIGN KEY (id_reply) REFERENCES replies(id) on DELETE CASCADE on UPDATE CASCADE  
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
                    

 
CREATE TABLE adscomments(
`id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_ads int(255) not null ,
    email_user varchar(50) not null, 
    FOREIGN key(id_ads) REFERENCES ads(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE  

)ENGINE=InnoDB DEFAULT CHARSET=utf8;
 


CREATE TABLE adsreplies(
`id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_ads int(255) not null ,
    email_user varchar(50) not null,
    id_comment int(255) not null,
    FOREIGN key(id_ads) REFERENCES ads(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(id_comment) REFERENCES adscomments(id) on DELETE CASCADE on UPDATE CASCADE 

)ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
CREATE TABLE adsreport(id int(255) not null AUTO_INCREMENT PRIMARY key,
                    id_ads int(255) not null,
                    email_user_report varchar(50) not null,
                    email_user_abuse varchar(50) not null,
                    id_comment int(255) null,
                    id_reply int(255) null,
                    date_report datetime not null,
                    type varchar(50) not null,
                    other longtext null ,
                    FOREIGN KEY(id_ads) REFERENCES ads(id) on DELETE CASCADE on UPDATE CASCADE,
                    FOREIGN KEY(email_user_report) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE,
                    FOREIGN KEY(email_user_abuse) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE,
                    FOREIGN KEY(id_comment) REFERENCES adscomments(id) on DELETE CASCADE on UPDATE CASCADE ,
                    FOREIGN KEY (id_reply) REFERENCES adsreplies(id) on DELETE CASCADE on UPDATE CASCADE  
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
                    

 CREATE TABLE settings(id int(255) not null PRIMARY key,
                    numberofs int(255) not null  
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
 insert into settings values(1,10),(2,2),(3,10);
  
 CREATE TABLE account(id int(255) not null PRIMARY key,
                    email varchar(100)  null, 
                    password varchar(100)  null,  
                    host varchar(100)  null,  
                    port int  null,
                    maxsizecomments int  null ,
                    smtpsecure varchar(100)  null  ,
                    link varchar(100)  null 
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

 insert into account values(1,"noreply@chatsrun.com","@ftre34#kl987La","mail.chatsrun.com",465,20,"ssl","https://www.fyipress.net/arabic");

 CREATE TABLE dates(date date not null PRIMARY key )ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE countries(country varchar(100) not null PRIMARY key,
  geoplugin_city text,geoplugin_countryCode varchar(100),
  geoplugin_timezone varchar(100))ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE visitors(date date ,country varchar(100),nb int(255) DEFAULT 1,
  FOREIGN KEY(date) REFERENCES dates(date) on DELETE CASCADE on UPDATE CASCADE,
  FOREIGN KEY(country) REFERENCES countries(country) on DELETE CASCADE on UPDATE CASCADE,
   primary key (date, country)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8; 

create table total_visitors( 
session varchar(250) primary key,
ip varchar(250),
time int(250),time2 int(250),country varchar(100),
FOREIGN KEY(country) REFERENCES countries(country) on DELETE CASCADE on UPDATE CASCADE  )ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
 
  
CREATE TABLE rss_sources (id int(255) not null PRIMARY key,
                         source varchar(100)  null, 
                         type varchar(100)  null,    
                         status int  null ,country varchar(100)  null
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8;




 CREATE TABLE `rss` (`id` int(200) NOT NULL AUTO_INCREMENT primary key,
                  `title` longtext NOT NULL,
                  `description` longtext  NULL,
                  `link` longtext NOT NULL,
                  `pubDate` text NOT NULL, 
                  `media` text  NULL, 
                  `favorite` int(255) null,
                  `thumbnail` longtext  NULL ,
                  FOREIGN KEY (favorite) REFERENCES rss_sources(id) on DELETE CASCADE on UPDATE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



 
     CREATE TABLE user_sources (`email` varchar(50) NOT NULL ,
      id int(255) not null ,  PRIMARY key(email,id),  
      FOREIGN KEY(id) REFERENCES rss_sources(id) on DELETE CASCADE on UPDATE CASCADE, 
      FOREIGN KEY(email) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE
      )
     ENGINE=InnoDB DEFAULT CHARSET=utf8;

      
/*****/ 

CREATE TABLE `rss_tmp` (`id` int(200) NOT NULL AUTO_INCREMENT primary key,
                  `title` longtext NOT NULL,
                  `description` longtext  NULL,
                  `link` tinytext NOT NULL,
                  `pubDate` text NOT NULL, 
                  `media` text  NULL, 
                  `favorite` int(255) null,
                  `thumbnail` text  NULL ,
                  FOREIGN KEY (favorite) REFERENCES rss_sources(id) on DELETE CASCADE on UPDATE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* v4 */
  CREATE TABLE user_news (`email` varchar(50) NOT NULL ,
      id int(255) not null ,  PRIMARY key(email,id),  
      FOREIGN KEY(id) REFERENCES news_published(id) on DELETE CASCADE on UPDATE CASCADE, 
      FOREIGN KEY(email) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE
      )ENGINE=InnoDB DEFAULT CHARSET=utf8;  

  CREATE TABLE user_ads (`email` varchar(50) NOT NULL ,
      id int(255) not null ,  PRIMARY key(email,id),  
      FOREIGN KEY(id) REFERENCES ads(id) on DELETE CASCADE on UPDATE CASCADE, 
      FOREIGN KEY(email) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE
      )ENGINE=InnoDB DEFAULT CHARSET=utf8; 

/* v5 */ 
CREATE TABLE rss_comments(
`id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_news int(200) not null ,
    email_user varchar(50) not null, 
    FOREIGN key(id_news) REFERENCES rss(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE   
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE rss_replies(
`id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_news int(200) not null ,
    email_user varchar(50) not null,
    id_comment int(255) not null,
    FOREIGN key(id_news) REFERENCES rss(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(id_comment) REFERENCES rss_comments(id) on DELETE CASCADE on UPDATE CASCADE 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE rss_report(id int(255) not null AUTO_INCREMENT PRIMARY key,
                    id_news int(200) not null,
                    email_user_report varchar(50) not null,
                    email_user_abuse varchar(50) not null,
                    id_comment int(255) null,
                    id_reply int(255) null,
                    date_report datetime not null,
                    type varchar(50) not null,
                    other longtext null ,
                    FOREIGN KEY(id_news) REFERENCES rss(id) on DELETE CASCADE on UPDATE CASCADE,
                    FOREIGN KEY(email_user_report) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE,
                    FOREIGN KEY(email_user_abuse) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE,
                    FOREIGN KEY(id_comment) REFERENCES rss_comments(id) on DELETE CASCADE on UPDATE CASCADE ,
                    FOREIGN KEY (id_reply) REFERENCES rss_replies(id) on DELETE CASCADE on UPDATE CASCADE  
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
 
CREATE TABLE footer(id int(255) not null PRIMARY key,
                    aboutus longtext  null, 
                    chatsrun text  null,  
                    whatsapp text  null,  
                    email text  null, 
                    fyi_likes int(255)  null , 
                    twitter text  null ,
                    facebook text  null ,
                    youtube text  null 
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
     
/* v6 */ 
CREATE TABLE `language_users` (
  `email` varchar(50) NOT NULL  primary key,
  `name` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `isEmailConfirmed` tinyint(4) NOT NULL,
  `token` varchar(10) COLLATE utf8_unicode_ci NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;  
 

/* v7 */
CREATE TABLE `messages` (
  `id` bigint(20) not null AUTO_INCREMENT PRIMARY key,
  `email` varchar(50) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(100) NOT NULL,
  `subject` text NOT NULL, 
  `message` text NOT NULL , 
  `phone` varchar(50) NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;  
   
/* temp  */  
CREATE TABLE temp_comments(
    `id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_news int(255) not null ,
    email_user varchar(50) not null, 
    FOREIGN key(id_news) REFERENCES news_published(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE  
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE temp_replies(  
    `id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_news int(255) not null ,
    email_user varchar(50) not null,
    id_comment int(255) not null,
    FOREIGN key(id_news) REFERENCES news_published(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE temp_adscomments(
    `id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime, 
    id_ads int(255) not null ,
    email_user varchar(50) not null, 
    FOREIGN key(id_ads) REFERENCES ads(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE  
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE temp_adsreplies(
    `id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_ads int(255) not null ,
    email_user varchar(50) not null,
    id_comment int(255) not null,
    FOREIGN key(id_ads) REFERENCES ads(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE  
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE temp_rss_comments(
    `id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_news int(200) not null ,
    email_user varchar(50) not null, 
    FOREIGN key(id_news) REFERENCES rss(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE   
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
   
CREATE TABLE temp_rss_replies(
`id` int(255) not null AUTO_INCREMENT PRIMARY key,
    response longtext ,
    media tinytext null,
    time datetime ,
    id_news int(200) not null , 
    email_user varchar(50) not null,
    id_comment int(255) not null,
    FOREIGN key(id_news) REFERENCES rss(id) on DELETE CASCADE on UPDATE CASCADE ,
    FOREIGN key(email_user) REFERENCES utilisateurs(email) on DELETE CASCADE on UPDATE CASCADE  
)ENGINE=InnoDB DEFAULT CHARSET=utf8; 
    
 
 
/* rss v2 */
insert into rss_sources values(1,"cnn","Sports",1,"United States"), (2,"cnn","News",1,"United States"), (3,"cnn","Technology",1,"United States"),
                          (4,"aawsat","Sports",1,"United Kingdom"), (5,"aawsat","Arts",1,"United Kingdom"), (6,"aawsat","Technology",1,"United Kingdom"),
                          (7,"alraimedia","General Culture",1,"Kuwait"),
                          (8,"aljazeera","News",1,"Qatar"),
                          (9,"alwatanvoice","News",1,"Palestine"), (10,"alwatanvoice","Sports",1,"Palestine"),
                          (11,"alwatanvoice","Arts",1,"Palestine"), (12,"alwatanvoice","General Culture",1,"Palestine"),
                          (13,"bbc","News",1,"United Kingdom"),
                          (14,"radiosawa","Technology",1,"United States"), (15,"radiosawa","Sports",1,"United States"), (16,"radiosawa","General Culture",1,"United States"),
                          (17,"skynewsarabia","News",1,"United Kingdom");
 

insert into rss_sources values(18,"RT Arabic","News",1,"Russia"), (19,"arabi21","News",1,"Turkey")
,(20,"Anadolu Agency","News",1,"Turkey"),(21,"alarab_qa","News",1,"Qatar"),(22,"yenisafak","News",1,"Turkey")
,(23,"As Arabia","Sports",1,"Spain"),(24,"alsopar","Sports",1,"Saudi Arabia")
,(25,"alblaad","News",1,"Kuwait"),(26,"alblaad","Sports",1,"Kuwait"),(27,"alblaad","Arts",1,"Kuwait")
,(28,"alblaad","General Culture",1,"Kuwait"),(29,"alblaad","Technology",1,"Kuwait")
,(30,"arabicpost","News",1,"Saudi Arabia");  
 

insert into footer values(1,"نحن موقع إخباري ... ننتمي إلى شبكة التواصل الإجتماعي (شاتس رن) ... ولا نسمح بإزدراء أي دين أو عرق أو لون على شبكتنا ... وعلى الدوام تسعدنا إقتراحاتكم",
  "https://www.chatsrun.com/","https://api.whatsapp.com/send?phone=97450279427",
  "contact_us.php",1,"https://twitter.com/","https://www.facebook.com/",
  "https://www.youtube.com"); 
 

CREATE TABLE sources_not_open(  
    source varchar(100) not null PRIMARY key
  )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
insert into sources_not_open values('alarab_qa'),('Anadolu Agency'),('arabi21'),('aljazeera'),
  ('arabicpost'),('aawsat'),('As Arabia');

 create table links  (id int(255) not null PRIMARY key, http_link longtext  null, 
                    https_link longtext  null )ENGINE=InnoDB DEFAULT CHARSET=utf8;  
insert into links(1,'https://www.fyipress.net/arabic','https://www.fyipress.net/arabic'); 