/* TABLE : Member */
CREATE TABLE crs_member (
  id         VARCHAR(80) NOT NULL,                /* Member ID */
  password   VARCHAR(60) NOT NULL,                /* Password */
  name       VARCHAR(40) NOT NULL,                /* Member name */
  tel        VARCHAR(11) NOT NULL,                /* Member telephone number */
  memo       TEXT        NULL,                    /* Memo */
  is_admin   BOOLEAN     NOT NULL DEFAULT FALSE,  /* Member type : TRUE(Admin) or FALSE(Customer) */
  PRIMARY KEY (id)
);


/* TABLE : Equipment type */
CREATE TABLE crs_equipment_type (
  sn   TINYINT(1) UNSIGNED NOT NULL,  /* Equipment type serial number */
  name VARCHAR(10)         NOT NULL,  /* Equipment type name : Camera, Lens */
  PRIMARY KEY (sn)
);

/* TABLE : Equipment */
CREATE TABLE crs_equipment (
  sn           BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT, /* Equipment serial number */
  is_enabled   BOOLEAN             NOT NULL,                /* Equipment state : TRUE(Rental enabled) or FALSE(Rental disabled) */
  type_sn      TINYINT(1) UNSIGNED NOT NULL,                /* Equipment type */
  manufacturer VARCHAR(40)         NOT NULL,                /* Equipment manufacturer name */
  model        VARCHAR(80)         NOT NULL,                /* Equipment model name */
  memo         TEXT                NULL,                    /* Memo */
  PRIMARY KEY (sn),
  FOREIGN KEY (type_sn) REFERENCES crs_equipment_type (sn)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
);


/* TABLE : Reservation status */
CREATE TABLE crs_reservation_status (
  sn   TINYINT(1) UNSIGNED NOT NULL,  /* Reservation status serial number */
  name VARCHAR(10)         NOT NULL,  /* Reservation status name : Request, Accept, Deny, Finish */
  PRIMARY KEY (sn)
);

/* TABLE : Reservation */
CREATE TABLE crs_reservation (
  sn                BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,             /* Reservation serial number */
  status_sn         TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,                  /* Reservation status serial number */
  member_id         VARCHAR(80)         NOT NULL,                            /* Member ID */
  equipment_sn      BIGINT(11) UNSIGNED NOT NULL,                            /* Equipment serial number */
  start_datetime    DATETIME            NOT NULL,                            /* Schedule start date-time */
  end_datetime      DATETIME            NOT NULL,                            /* Schedule end date-time */
  memo              TEXT                NULL,                                /* Memo */
  register_datetime DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,  /* It is the date-time inserted in the database. */
  is_deleted        BOOLEAN             NOT NULL DEFAULT FALSE,              /* The record was deleted(TRUE) or not(FALSE). */
  PRIMARY KEY (sn),
  FOREIGN KEY (member_id) REFERENCES crs_member (id)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  FOREIGN KEY (equipment_sn) REFERENCES crs_equipment (sn)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  FOREIGN KEY (status_sn) REFERENCES crs_reservation_status (sn)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
);


/* Insert records on crs_equipment_type */
/* 0 -> Camera, 1 -> Lens */
INSERT INTO crs_equipment_type (sn, name)
VALUES (0, '카메라'), (1, '렌즈');


/* Insert records on crs_reservation_status */
/* 0 -> Request, 1 -> Accept, 2 -> Deny, 3 -> Finish */
INSERT INTO crs_reservation_status (sn, name)
VALUES (0, '신청'), (1, '승인'), (2, '반려'), (3, '완료');

/* Insert the record about administrator on crs_reservation_status */
INSERT INTO crs_member (id, password, name, tel, memo, is_admin)
VALUES ('admin', SHA('admin'), 'admin', '01000000000', 'admin', TRUE);
