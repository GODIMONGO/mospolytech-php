<?php
function getDB(): PDO {
    static $db = null;
    if ($db === null) {
        $db = new PDO('sqlite:/tmp/contacts.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->exec("CREATE TABLE IF NOT EXISTS contacts (
            id       INTEGER PRIMARY KEY AUTOINCREMENT,
            surname  TEXT NOT NULL,
            name     TEXT NOT NULL,
            lastname TEXT NOT NULL DEFAULT '',
            gender   TEXT NOT NULL DEFAULT '',
            date     TEXT NOT NULL DEFAULT '',
            phone    TEXT NOT NULL DEFAULT '',
            location TEXT NOT NULL DEFAULT '',
            email    TEXT NOT NULL DEFAULT '',
            comment  TEXT NOT NULL DEFAULT ''
        )");
    }
    return $db;
}
