<?php
$cluster = Cassandra::cluster()
               ->withContactPoints('deep04.acis.ufl.edu')
               ->build();

$keyspace  = 'prisma1';
$session   = $cluster->connect($keyspace); 

echo 'page loaded';
?>