<html>
<body>
<head>
<META HTTP-EQUIV=Refresh CONTENT="2; URL=game.php">
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<title>Gomoku</title>
</head>

<?php
$x = $_GET["position_x"];
$y = $_GET["position_y"];
$SQ = 30; // rozmiar pola planszy
$BS = 15; // rozmiar planszy
$playerID = -1; // numer gracza; -1 oznacza �e nie bierze udzia�u w grze
$playerColor; // kolor pionk�w gracza
$playersCount; // ilo�� graczy
$turn; // czyja jest kolejka; je�li mniejsza od 0, m�wi o tym kt�ry gracz
       // wygra� (np. -2 oznacza �e wygra� gracz drugi, tzn. o playerID = 1)
       // -99 oznacza, �e jest remis
$cantJoin = false; // je�li gracz chcia� do��czy�, a by� ju� komplet 4 graczy

// odczytujemy informacje o graczach
$dane=file("data/players.txt");
$playersCount=count($dane);
for($q=0; $q < $playersCount; $q++) {
  if (trim($dane[$q]) == $_COOKIE["player"]) {
    //echo "Bierzesz udzia� w grze.";
    $playerID = $q;
  }
}

// dodajemy gracza w razie potrzeby
if ($_GET["join"] == "true") {
  if ($playersCount > 4) {
    $cantJoin = true;
  } else if (!in_array($_COOKIE["player"]."\n", $dane)) {
    $pfile=fopen("data/players.txt", "a");
    flock($pfile, 2);
    fputs($pfile, $_COOKIE["player"]."\n");
    flock($pfile, 3);
    fclose($pfile);
    $playerID = $playersCount;
  }
}

// je�li gracz zako�czy�, usuwamy go z listy graczy
if ($_GET["exit"] == "true") {
  $dane=file("data/players.txt");
  $lines=count($dane);
  for($q=0; $q < $lines; $q++) {
    if (trim($dane[$q]) == $_COOKIE["player"]) {
      unset($dane[$q]);
    }
  }
  $pfile=fopen("data/players.txt", "w");
  flock($pfile, 2);
  for($q=0; $q < $lines-1; $q++) {
    fputs($pfile, $dane[$q]);
  }
  flock($pfile, 3);
  fclose($pfile);
  $playerID = $playersCount;
}

// odczytujemy plansz� z pliku
$dane=file("data/board.txt");
$lines=count($dane);
for($q=0; $q < $lines; $q++) {
  $info=explode("|", "$dane[$q]");
  $r = 0;
  foreach ($info as $kolor_pola) {
    if (!empty($kolor_pola)) {
      $board[$r][$q] = $kolor_pola;
    } else {
      $board[$r][$q] = " ";
    }
    $r++;
  }
}

// odczytujemy czyja jest kolej
$turndata=file("data/turn.txt");
$turn = trim($turndata[0]);

// je�li zrestartowano, czy�cimy plansz�
if ($_GET["restart"] == "true") {
  // ustawiamy, �e zaczyna gracz 1
  $turn = 0;
  $tfile=fopen("data/turn.txt", "w");
  flock($tfile, 2);
  fputs($tfile, $turn);
  flock($tfile, 3);
  fclose($tfile);
  // czy�cimy plansz�
  $bfile=fopen("data/board.txt", "w");
  flock($bfile, 2);
  for ($j=0; $j < $BS; $j++) {
    for ($i=0; $i < $BS; $i++) {
	fputs($bfile, " |");
    } fputs($bfile, "\n");
  }
  flock($bfile, 3);
  fclose($bfile);
}
?>
<h3>Gomoku</h3>
U�� 5 kul tego samego koloru w rz�dzie poziomo, pionowo lub na skos.
<br><br>

<FORM ACTION="game.php" METHOD=GET>
<INPUT TYPE=IMAGE NAME="position" SRC="board.php">
</FORM>

<a href="game.php">Od�wie�</a>
<a href="game.php?restart=true">Nowa gra</a>
<a href="game.php?exit=true">Zako�cz gr�</a>
<br><br>

<?php
$wait_warning = false;
if ($playerID != -1 && $playersCount > 1 && $x > 0 && $y > 0
    && $turn >= 0) { // je�li gracz gra, pr�bujemy wykona� ruch
  if ($turn == $playerID && $x > 0 && $y > 0) {
    $move_success = false; // czy wykonanie ruchu si� powiod�o
    // zamieniamy wsp�rz�dne na obrazku na wsp�rz�dne na planszy
    $x = $x / $SQ;
    $y = $y / $SQ;
    // sprawdzamy kolor gracza
    if ($playerID == 0) {
      $playerColor = "b"; // kolor; "b" to czarny
    } else if ($playerID == 1) {
      $playerColor = "r"; // kolor; "r" to czerwony
    } else if ($playerID == 2) {
      $playerColor = "g"; // kolor; "g" to zielony
    } else if ($playerID == 3) {
      $playerColor = "l"; // kolor; "l" to niebieski
    }
    if ($board[$x][$y] == " ") {
      // wykonujemy ruch
      $board[$x][$y] = $playerColor;
      $move_success = true;
    }

    if ($move_success) {
      // zapisujemy aktualny stan planszy do pliku
      $bfile=fopen("data/board.txt", "w");
      flock($bfile, 2);
      for ($j=0; $j < $BS; $j++) {
	for ($i=0; $i < $BS; $i++) {
	  //if ($board[$i][$j] != " ") {
	    fputs($bfile, $board[$i][$j]."|");
	  //} else {
	    //fputs($bfile, " |");
	  //}
	}
	fputs($bfile, "\n");
      }
      flock($bfile, 3);
      fclose($bfile);

      // sprawdzamy czy by� to ruch zwyci�ski
      $pc = $playerColor;
      for ($j=0; $j < $BS; $j++) {
	for ($i=0; $i < $BS; $i++) {
	  // w poziomie: -
	  if ($board[$i][$j] == $pc
	    && $board[$i-1][$j] == $pc && $board[$i-2][$j] == $pc
	    && $board[$i+1][$j] == $pc && $board[$i+2][$j] == $pc) {
	      $turn = $playerID*(-1)-1;
	  }
	  // w pionie: |
	  if ($board[$i][$j] == $pc
	    && $board[$i][$j-1] == $pc && $board[$i][$j-2] == $pc
	    && $board[$i][$j+2] == $pc && $board[$i][$j+2] == $pc) {
	      $turn = $playerID*(-1)-1;
	  }
	  // na ukos: \
	  if ($board[$i][$j] == $pc
	    && $board[$i-1][$j-1] == $pc && $board[$i-2][$j-2] == $pc
	    && $board[$i+1][$j+1] == $pc && $board[$i+2][$j+2] == $pc) {
	      $turn = $playerID*(-1)-1;
	  }
	  // na ukos: /
	  if ($board[$i][$j] == $pc
	    && $board[$i-1][$j+1] == $pc && $board[$i-2][$j+2] == $pc
	    && $board[$i+1][$j-1] == $pc && $board[$i+2][$j-2] == $pc) {
	      $turn = $playerID*(-1)-1;
	  }
	}
      }

      // zmieniamy kolejk�
      $tfile=fopen("data/turn.txt", "w");
      flock($tfile, 2);
      if ($turn == $playersCount-1) {
	$turn = 0;
      } else if ($turn >= 0) {
	$turn = $turn + 1;
      }
      fputs($tfile, $turn);
      flock($tfile, 3);
      fclose($tfile);
    }
  } else {
    $wait_warning = true;
  }
}

?>
<?php
echo "Ilo�� graczy: ".$playersCount."<br>";
if ($playersCount < 2) {
  echo "Zbyt ma�a ilo�� graczy...<br>";
}
if ($playerID == -1) {
  echo "<a href=\"game.php?join=true\">Do��cz si� do gry</a><br><br>\n";
} else if ($playersCount > 1) {
  echo "Jeste� graczem numer ".($playerID+1)."<br><br>\n";
  if ($playerID == $turn) {
    echo "Teraz jest twoja kolej<br><br>\n";
  } else if ($turn >= 0) {
    echo "Teraz jest kolejka gracza ".($turn+1)."<br><br>\n";
  }
  if ($wait_warning)
    echo "<div style=\"color:red;\">Poczekaj na swoj� kolejk�!</div><br><br>\n";
  if ($turn == -99) {
    echo "<div style=\"color:red;\">Remis.</div><br><br>\n";
  } else if ($turn < 0) {
    echo "<div style=\"color:red;\">Wygra� gracz ".($turn*(-1))."</div><br><br>\n";
  }
  if ($cantJoin)
    echo "<div style=\"color:red;\">Nie mo�esz do��czy�: jest ju� komplet graczy.</div><br><br>\n";
}
?>

<!--
<br><br>
x = <?php echo $x ?><br>
y = <?php echo $y ?><br>
-->
</body>
</html>
