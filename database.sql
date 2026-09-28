create database if not exists stk_support
    character set utf8mb4
    collate utf8mb4_unicode_ci;

use stk_support;

create table if not exists schools (
    id bigint unsigned not null auto_increment primary key,
    name varchar(200) not null,
    category varchar(80) not null,
    region varchar(160) not null,
    status enum('published', 'draft') not null default 'draft',
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp,
    index idx_schools_status_updated (status, updated_at)
) engine=InnoDB default charset=utf8mb4 collate=utf8mb4_unicode_ci;

insert ignore into schools (id, name, category, region, status, updated_at) values
    (24, '東京デザインテクノロジーセンター', '専門学校', '東京都新宿区', 'published', '2026-09-26 00:00:00'),
    (2, '早稲田大学', '大学', '東京都新宿区', 'published', '2026-09-25 00:00:00'),
    (31, '横浜医療専門学校', '専門学校', '神奈川県横浜市', 'draft', '2026-09-24 00:00:00'),
    (5, '明治大学', '大学', '東京都千代田区', 'published', '2026-09-21 00:00:00');

create table if not exists contact_messages (
    id bigint unsigned not null auto_increment primary key,
    name varchar(120) not null,
    email varchar(320) not null,
    message text not null,
    created_at timestamp not null default current_timestamp
) engine=InnoDB default charset=utf8mb4 collate=utf8mb4_unicode_ci;