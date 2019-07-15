<?php
require_once 'database.php';

function work_create($title, $author, $publication, $category, $date, $keywords, $type, $userId)
{
  global $database;

  $category = implode(',', filterArray($category));

  $database->insert('works', [
    'title' => "{$title}",
    'author' => "{$author}",
    'publication' => "{$publication}",
    'category' => "{$category}",
    'date' => "{$date}",
    'keywords' => "{$keywords}",
    'type' => "{$type}",
    'userId' => $userId,
  ]);

  if ($err = $database->error()[2]) {
    return $err;
  } else {
    return false;
  }
}

function filterArray($arr)
{
  return array_filter($arr, function ($str) {
    return strlen($str) > 0;
  });
}

function work_select($type, $userId = null)
{
  global $database;

  if (is_null($userId)) {
    $rows = $database->select('works', '*', ['type' => "{$type}"]);
  } else {
    $rows = $database->select('works', '*', ['type' => "{$type}", 'userId' => $userId]);
  }

  return $rows;
}

function work_approve($ids)
{
  global $database;

  foreach ($ids as $id) {
    $database->update('works', [
      'status' => 'APPROVED',
    ], [
      'id' => $id,
    ]);
  }
}
