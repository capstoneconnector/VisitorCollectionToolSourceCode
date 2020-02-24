<?php


interface DbManagerInterface
{
    public static function readById(Entry $table, array $ids);
    public static function insert(Entry $entry);
    public static function update(Entry $entry);
    public static function delete();

}