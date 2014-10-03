<?php

// Kastar ett undantag när ett regulärt uttryck inte stämmer.
class InvalidCharException  extends \Exception{

} 

// Kastar ett undantag när längden på strängen är mindre än den angivna.
class TooShortException  extends \Exception{

} 

// Kastar ett undantag när två strängar inte överensstämmer.
class NoMatchException  extends \Exception{
} 

// Kastar ett undantag när två strängar inte överensstämmer.
class AllTooShortException  extends \Exception{
} 