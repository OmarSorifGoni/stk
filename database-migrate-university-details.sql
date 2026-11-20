ALTER TABLE schools
    ADD COLUMN description varchar(500) not null default '' AFTER region,
    ADD COLUMN jlpt_requirement varchar(120) not null default '' AFTER description,
    ADD COLUMN eju_requirement varchar(160) not null default '' AFTER jlpt_requirement,
    ADD COLUMN english_requirement varchar(160) not null default '' AFTER eju_requirement,
    ADD COLUMN tuition varchar(160) not null default '' AFTER english_requirement,
    ADD COLUMN website_url varchar(2048) not null default '' AFTER tuition;
