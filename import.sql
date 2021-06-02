CREATE OR REPLACE TABLE nat2019 (
    sexe ENUM('2', '1', 'Masculin', 'Féminin'),
    preusuel VARCHAR(40), -- Longueur max du prénom dans le fichier 2019 : 20
    annais VARCHAR(4), -- A filtrer
    nombre INT (10) UNSIGNED
);

CREATE OR REPLACE TABLE dpt2019 (
    sexe ENUM('2', '1', 'Masculin', 'Féminin'),
    preusuel VARCHAR(40), -- Longueur max du prénom dans le fichier 2019 : 20
    annais VARCHAR(4), -- A filtrer
    dpt VARCHAR(4), -- A filtrer
    nombre INT UNSIGNED
);

LOAD DATA INFILE '/fichier/nat2019.csv' INTO TABLE nat2019 FIELD TERMINATED BY ';' IGNORE 1 LINES;
LOAD DATA INFILE '/fichier/dpt2019.csv' INTO TABLE dpt2019 FIELD TERMINATED BY ';' IGNORE 1 LINES;

UPDATE  nat2019
SET     sexe = CASE sexe WHEN '1' THEN 'Masculin' WHEN '2' THEN 'Féminin' END;

UPDATE  dpt2019
SET     sexe = CASE sexe WHEN '1' THEN 'Masculin' WHEN '2' THEN 'Féminin' END;

UPDATE  nat2019
SET     annais = NULL
WHERE   annais = 'XXXX';

UPDATE  dpt2019
SET     annais = NULL
WHERE   annais = 'XXXX';

UPDATE  dpt2019
SET     dpt = NULL
WHERE   dpt = 'XX';

ALTER TABLE nat2019
  MODIFY sexe ENUM('Masculin', 'Féminin'),
  MODIFY annais SMALLINT UNSIGNED;

ALTER TABLE dpt2019
  MODIFY sexe ENUM('Masculin', 'Féminin'),
  MODIFY annais SMALLINT UNSIGNED,
  MODIFY dpt SMALLINT UNSIGNED;

ALTER TABLE nat2019
  ADD INDEX IDX_nat_annais_preusuel (annais, preusuel),
  ADD INDEX IDX_nat_preusuel (preusuel);

ALTER TABLE dpt2019
  ADD INDEX IDX_dpt_annais_dpt_preusuel (annais, dpt, preusuel),
  ADD INDEX IDX_dpt_preusuel (preusuel),
  ADD INDEX IDX_dpt_dpt (dpt);

CREATE OR REPLACE TABLE natdec2019 AS
SELECT  sexe,
        preusuel,
        annais - (annais % 10) AS annais,
        SUM(nombre)
FROM    nat2019
GROUP BY sexe,
        preusuel,
        annais - (annais % 10);

CREATE OR REPLACE TABLE dptdec2019 AS
SELECT  sexe,
        preusuel,
        annais - (annais % 10) AS annais,
        dpt,
        SUM(nombre)
FROM    dpt2019
GROUP BY sexe,
        preusuel,
        annais - (annais % 10),
        dpt;

ALTER TABLE natdec2019
  ADD INDEX IDX_natdec_annais_preusuel (annais, preusuel),
  ADD INDEX IDX_natdec_preusuel (preusuel);

ALTER TABLE dptdec2019
  ADD INDEX IDX_dptdec_annais_dpt_preusuel (annais, dpt, preusuel),
  ADD INDEX IDX_dptdec_preusuel (preusuel),
  ADD INDEX IDX_dptdec_dpt (dpt);
