<?php
  $new_url = $_REQUEST['url'];
  header("Location: " . $new_url);
  die ();
