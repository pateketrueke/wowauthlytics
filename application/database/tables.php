<?php

$account = array(
    'id' => array('primary_key'),
    'emailaddr' => array('string'),
    'unique_hash' => array('string'),
  );

$provider = array(
    'id' => array('primary_key'),
    'name' => array('string'),
    'account_id' => array('integer'),
  );

foreach (array('account', 'provider') as $table) {
  ! isset($db[$table]) && $db[$table] = $$table;

  $columns = $db[$table]->columns();

  if (sizeof($$table) <> sizeof($columns)) {
    unset($db[$table]);
  } else {
    foreach ($$table as $column => $type) {
      $type = array_shift($type);
      if ( ! isset($columns[$column]) OR ($columns[$column]['type'] <> $type)) {
        unset($db[$table]);
      }
    }
  }

  $$table = $db[$table];
}
