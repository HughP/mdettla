Cwiczenia 9
Zadanie (do 18 maja)
Stworzyć następujące filtry:
* formatujący wynik (ładne wcięcia)
* pomijający określone znaczniki (podane przez użytkownika)
* zamieniający przestrzenie nazw na podane przez użytkownika przy uruchomieniu programu (Uwaga: plik .xml może miec kilka różnych przestrzeni nazw, należy wskazać jakie przetrzenie nazw chcemy zamienić na jakie)
* zamieniający nazwy elementów na pisane dużymi literami (prefixy sie nie zmieniają)
* zamieniający nazwy atrybutów na pisane małymi literami (prefixy się nie zmieniają)
Napisać program, który bedzie korzystał z powyższych filtrów. Ilość używanych (przy uruchomieniu nie trzeba zawsze korzystać z wszystkich i tych samych filtrów) filtrów i kolejność ich użycia powinna byc określana za pomocą argumentów wywołania.

Kompilacja:
javac -cp java-getopt-1.0.13.jar *java
Aby zobaczyć dostępne opcje:
java -cp .:java-getopt-1.0.13.jar FilterChain
Przykład użycia:
java -cp .:java-getopt-1.0.13.jar FilterChain -i -s "head tr" -n "http://moja.przestrzen http://inna.przestrzen" -ta example.xml
