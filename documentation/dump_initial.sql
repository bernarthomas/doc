DROP TABLE IF EXISTS document ;
CREATE TABLE document (doc_id BIGINT  AUTO_INCREMENT NOT NULL,
doc_title VARCHAR(255),
doc_filepath VARCHAR(255),
PRIMARY KEY (doc_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS user ;
CREATE TABLE user (user_id BIGINT  AUTO_INCREMENT NOT NULL,
user_lastname VARCHAR(255),
user_firstname VARCHAR(255),
PRIMARY KEY (user_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS _n_category ;
CREATE TABLE _n_category (ncat_id BIGINT  AUTO_INCREMENT NOT NULL,
ncat_label VARCHAR(255),
PRIMARY KEY (ncat_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS history ;
CREATE TABLE history (hist_id BIGINT  AUTO_INCREMENT NOT NULL,
hist_dt DATETIME,
nhist_id BIGINT NOT NULL,
PRIMARY KEY (hist_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS _n_history ;
CREATE TABLE _n_history (nhist_id BIGINT  AUTO_INCREMENT NOT NULL,
nhist_label VARCHAR(255),
PRIMARY KEY (nhist_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS _n_group ;
CREATE TABLE _n_group (ngroup_id BIGINT  AUTO_INCREMENT NOT NULL,
ngroup_label VARCHAR(255),
PRIMARY KEY (ngroup_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS _a_docuser ;
CREATE TABLE _a_docuser (doc_id BIGINT  AUTO_INCREMENT NOT NULL,
user_id BIGINT NOT NULL,
PRIMARY KEY (doc_id,
 user_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS _a_docat ;
CREATE TABLE _a_docat (ncat_id BIGINT  AUTO_INCREMENT NOT NULL,
doc_id BIGINT NOT NULL,
PRIMARY KEY (ncat_id,
 doc_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS _a_userhist ;
CREATE TABLE _a_userhist (user_id BIGINT  AUTO_INCREMENT NOT NULL,
hist_id BIGINT NOT NULL,
PRIMARY KEY (user_id,
 hist_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS _a_dochist ;
CREATE TABLE _a_dochist (doc_id BIGINT  AUTO_INCREMENT NOT NULL,
hist_id BIGINT NOT NULL,
PRIMARY KEY (doc_id,
 hist_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS _a_docgroup ;
CREATE TABLE _a_docgroup (doc_id BIGINT  AUTO_INCREMENT NOT NULL,
ngroup_id BIGINT NOT NULL,
PRIMARY KEY (doc_id,
 ngroup_id) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS _a_grouphist ;
CREATE TABLE _a_grouphist (hist_id BIGINT  AUTO_INCREMENT NOT NULL,
ngroup_id BIGINT NOT NULL,
PRIMARY KEY (hist_id,
 ngroup_id) ) ENGINE=InnoDB;

ALTER TABLE history ADD CONSTRAINT FK_history_nhist_id FOREIGN KEY (nhist_id) REFERENCES _n_history (nhist_id);

ALTER TABLE _a_docuser ADD CONSTRAINT FK__a_docuser_doc_id FOREIGN KEY (doc_id) REFERENCES document (doc_id);
ALTER TABLE _a_docuser ADD CONSTRAINT FK__a_docuser_user_id FOREIGN KEY (user_id) REFERENCES user (user_id);
ALTER TABLE _a_docat ADD CONSTRAINT FK__a_docat_ncat_id FOREIGN KEY (ncat_id) REFERENCES _n_category (ncat_id);
ALTER TABLE _a_docat ADD CONSTRAINT FK__a_docat_doc_id FOREIGN KEY (doc_id) REFERENCES document (doc_id);
ALTER TABLE _a_userhist ADD CONSTRAINT FK__a_userhist_user_id FOREIGN KEY (user_id) REFERENCES user (user_id);
ALTER TABLE _a_userhist ADD CONSTRAINT FK__a_userhist_hist_id FOREIGN KEY (hist_id) REFERENCES history (hist_id);
ALTER TABLE _a_dochist ADD CONSTRAINT FK__a_dochist_doc_id FOREIGN KEY (doc_id) REFERENCES document (doc_id);
ALTER TABLE _a_dochist ADD CONSTRAINT FK__a_dochist_hist_id FOREIGN KEY (hist_id) REFERENCES history (hist_id);
ALTER TABLE _a_docgroup ADD CONSTRAINT FK__a_docgroup_doc_id FOREIGN KEY (doc_id) REFERENCES document (doc_id);
ALTER TABLE _a_docgroup ADD CONSTRAINT FK__a_docgroup_ngroup_id FOREIGN KEY (ngroup_id) REFERENCES _n_group (ngroup_id);
ALTER TABLE _a_grouphist ADD CONSTRAINT FK__a_grouphist_hist_id FOREIGN KEY (hist_id) REFERENCES history (hist_id);
ALTER TABLE _a_grouphist ADD CONSTRAINT FK__a_grouphist_ngroup_id FOREIGN KEY (ngroup_id) REFERENCES _n_group (ngroup_id);
