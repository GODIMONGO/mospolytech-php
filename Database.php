<?php
/**
 * Класс подключения к базе данных.
 *
 * Реализует паттерн "Одиночка" (Singleton): за всё время работы скрипта
 * создаётся только одно подключение PDO, которое переиспользуется во
 * всех контроллерах. Это экономит ресурсы и упрощает работу с БД.
 *
 * Используется SQLite — файл базы лежит в /tmp/kurs.sqlite. Такой путь
 * выбран потому, что папка проекта на хостинге может быть доступна только
 * для чтения, а /tmp всегда открыт для записи в контейнере.
 */
class Database
{
    /**
     * Сохранённое подключение. null означает "ещё не открывали".
     */
    private static ?PDO $connection = null;

    /**
     * Возвращает экземпляр PDO. При первом вызове создаёт подключение
     * и настраивает поведение драйвера; при последующих — отдаёт уже
     * существующее.
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            // sqlite: — DSN-префикс для драйвера SQLite в PDO.
            self::$connection = new PDO('sqlite:/tmp/kurs.sqlite');

            // Любая ошибка SQL будет брошена как исключение PDOException,
            // что удобно ловить и обрабатывать.
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // По умолчанию fetch() возвращает массив со строковыми ключами
            // (имена столбцов), а не дублирует значения с числовыми индексами.
            self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return self::$connection;
    }
}
