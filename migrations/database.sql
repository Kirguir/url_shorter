CREATE TABLE IF NOT EXISTS `links`
(
    `id`  bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `url` varchar(255)        NOT NULL
) CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `views`
(
    `link_id`   bigint(20) unsigned NOT NULL,
    `ip`        int unsigned        NOT NULL,
    `country`   varchar(32),
    `browser`   varchar(10),
    `version`   int,
    `os`        varchar(64),
    `viewed_at` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (link_id)
        REFERENCES links (id)
        ON DELETE CASCADE
) CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
