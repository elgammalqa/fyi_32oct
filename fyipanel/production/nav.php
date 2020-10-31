<?php
$a[0]="A";
$a[1]="Cat"; 
$a[2]="Dog";
$a[3]="A";
$a[4]="Dog";
$a[5]="A"; 
print_r(array_count_values($a));
 $countries=array_count_values($a);
 $max_country="";
 $real_val=0;
 foreach ($countries as $key => $value) {
  if($value>=$real_val){
    $real_val=$value;
    $max_country=$key;
  }
 }
 echo $max_country; 
 
 /*
 $table[0][0]="qa";
 $table[0][1]=20;
 $table[1][0]="us";
 $table[1][1]=40;
 $table[2][0]="qa";
 $table[2][1]=50;
 foreach ( $table as $movie ) { 
  foreach ( $movie as $key => $value ) {
    echo "$value<br>";
  } 
  echo "------<br>";
}

 
 $table["qa"]=20; 
 $table["us"]=30;  
 $table["qa"]=50; 
  foreach ( $table as $key => $value ) {
    echo "$key...$value<br>";
  } 
  */ 
?> 
