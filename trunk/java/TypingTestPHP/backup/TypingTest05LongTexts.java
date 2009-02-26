/**
 * @author Michal Dettlaff
 * @version 1.5
 */

/* <applet width=635 height=390 code="TypingTest.class"></applet> */

import java.applet.*;
import java.awt.*;
import java.awt.event.*;
import java.io.*;
import java.util.ArrayList;
import java.util.Date;
import java.util.Random;

/**
 * Test szybkosci pisania. F2 wylacza/wlacza polskie znaki.
 */
public class TypingTest extends Applet
    implements KeyListener, MouseListener {

  static final int FONT_SIZE=15;
  final int X_MAR=25;
  final int Y_MAR=25;
  final int LINE_HEIGHT=17;
  static String txtDirectory; // gdzie sa pliki do przepisywania
  static int maxCharsInLine;
  int width, height; // rozmiary apletu
  boolean showPolishChars;
  boolean showResults;
  boolean isTimerOn;
  boolean showWelcome;
  long timeStarted;
  long timeFinished;
  int charsTyped;
  int mistakesCount;
  Text text;
  Text typedText;
  Text mistakes;
  Font font;
  Font fontBig;
  Font fontSmall;

  public void init() {
    showPolishChars=true;
    isTimerOn=false;
    showResults=false;
    showWelcome=true;
    charsTyped=0;
    mistakesCount=0;
    maxCharsInLine=65;
    txtDirectory = "txt";
    loadNewTextToType(txtDirectory);

    width=getWidth();
    height=getHeight();
    setBackground(Color.WHITE);
    setForeground(Color.BLACK);
    font = new Font("Monospaced", Font.PLAIN, FONT_SIZE);
    fontBig = new Font("Serif", Font.PLAIN, 18);
    fontSmall = new Font("Serif", Font.PLAIN, 16);

    addKeyListener(this);
    addMouseListener(this);
  }

  public void paint(Graphics g) {
    int i;

    if (showWelcome) {
      g.setFont(fontBig);
      g.drawString("Test pr�dko�ci pisania", width/2-100, height/2-90);
      g.setFont(fontSmall);
      g.drawString("Po przepisaniu ka�dej linii naci�nij ENTER",
		           width/2-142, height/2-30);
      g.drawString("Czas zacznie by� mierzony, kiedy zaczniesz pisa�",
		           width/2-165, height/2-5);
      g.setFont(fontBig);
      g.drawString("Kliknij, aby rozpocz��", width/2-100, height/2+35);
      g.setColor(Color.BLUE);
      g.drawString("autor: Micha� Dettlaff", width/2-98, height/2+100);
      g.setColor(Color.BLACK);

    } else {

      g.setFont(font);
      for (i=0; i < text.size(); i++) {
	g.drawString(text.get(i), X_MAR, Y_MAR+2*i*LINE_HEIGHT);
      }

      g.setColor(Color.BLUE);
      for (int j=0; j < typedText.size(); j++) {
	g.drawString(typedText.get(j), X_MAR, Y_MAR+(2*j+1)*LINE_HEIGHT);
      }
      g.setColor(Color.BLACK);

      g.setColor(Color.RED);
      for (int k=0; k < mistakes.size(); k++) {
	g.drawString(mistakes.get(k), X_MAR, Y_MAR+(2*k+1)*LINE_HEIGHT);
      }
      g.setColor(Color.BLACK);

      if (showResults) {
	long typingTime = timeFinished - timeStarted;
	double tt = ((double) typingTime) / 1000;
	double ct = charsTyped;
	double speed = 60 * ct / tt;
	long typingTimeS = (timeFinished - timeStarted) / 1000;
	g.drawString("Wynik: " + String.format("%.1f", speed) + " znak�w/min, "
	    + mistakesCount + " b��d�w (" + charsTyped + " znakow w "
		+ typingTimeS + " sekund)",
		    X_MAR, Y_MAR+(2*i+1)*LINE_HEIGHT);
	g.drawString("Naci�nij ENTER, aby rozpocz�� kolejny test",
		 X_MAR, Y_MAR+2*(i+1)*LINE_HEIGHT);
      }
    }
    g.drawRect(0, 0, width-1, height-1);
  }

  public void mouseClicked(MouseEvent e) {
    showWelcome=false;
    repaint();
    e.consume();
  }

  public void mousePressed(MouseEvent e) {
  }

  public void mouseReleased(MouseEvent e) {
  }

  public void mouseEntered(MouseEvent e) {
  }

  public void mouseExited(MouseEvent e) {
  }

  public void keyReleased(KeyEvent e) {
  }

  public void keyPressed(KeyEvent e) {
    int ch=e.getKeyCode();

    if (ch == KeyEvent.VK_F2) {
      if (!isTimerOn && !showResults) { // widac tekst, ale jeszcze nie piszemy
	text.removePolishChars();
	repaint();
      }
      showPolishChars=!showPolishChars;
    }
    e.consume();
  }

  public void keyTyped(KeyEvent e) {
    char ch=e.getKeyChar();

    if (!showResults && !showWelcome) {
      if (ch == KeyEvent.VK_BACK_SPACE) {
	if (typedText.getLast().length() > 0) { // inaczej
	  String s = typedText.getLast();     // RuntimeException
	  s = s.substring(0, s.length()-1);
	  typedText.setLast(s);
	  charsTyped--;
	  // wymazujemy tez z tablicy przechowujacej pomylki
	  s = mistakes.getLast();
	  if (s.charAt(s.length()-1) != ' ') {
	    mistakesCount--;
	  }
	  s = s.substring(0, s.length()-1);
	  mistakes.setLast(s);
	}
      } else if (ch == KeyEvent.VK_ENTER) {
	if (charsTyped > 0) {
	  // sprawdza, czy nie wpisalismy za krotkiej linii, bo to blad
	  // jesli tak, to dodajemy podkreslenie az do konca linii
	  if (typedText.getLast().length() < text.get(
				     typedText.size()-1).length()) {
	    String underline = "";
	    int gapSize=text.get(typedText.size()-1).length()
				- typedText.getLast().length();
	    for (int i=0; i < gapSize; i++) {
	      underline += '_';
	      mistakesCount++;
	    }
	    mistakes.setLast(mistakes.getLast().concat(underline));
	  }
	  mistakes.add(""); // nowa linia do zapamietywania bledow
	  typedText.add("");
	  charsTyped++; // ENTER to tez znak
	  if (typedText.size() > text.size()) { // jesli to byla ostatnia linia
	    timeFinished=(new Date()).getTime();
	    showResults=true;
	    isTimerOn=false;
	  }
	}
      } else {
	if (!isTimerOn) {
	  timeStarted=(new Date()).getTime();
	  isTimerOn=true;
	}
	String s = typedText.getLast();
        s += ch;
	typedText.setLast(s);
	charsTyped++;
	// jesli jest blad, zapisujemy go w tablicy mistakes
	s = text.get(typedText.size()-1);
	if (typedText.getLast().length() > s.length()) { // przekroczona linia
	  s = mistakes.getLast();
	  s += '_';
	  mistakes.setLast(s);
	  mistakesCount++;
	} else {
	  if (ch != s.charAt(typedText.getLast().length()-1)) {
	    s = mistakes.getLast();
	    s += '_';
	    mistakes.setLast(s);
	    mistakesCount++;
	  } else {
	    s = mistakes.getLast();
	    s += ' ';
	    mistakes.setLast(s);
	  }
	}
      }
      repaint();
    } else if (!showWelcome) {
      if (ch == KeyEvent.VK_ENTER) { // restart, nowy tekst
	showResults=false;
	charsTyped=0;
	loadNewTextToType(txtDirectory);
        repaint();
      }
    } else {
      showWelcome=false;
      repaint();
    }
    e.consume();
  }

  /** Czyta losowo wybrany plik z danego katalogu. */
  void loadNewTextToType(String directory) {
    int fileIndex;
    File[] files = new File(directory).listFiles();

    Random rand = new Random(new Date().getTime());
    fileIndex=rand.nextInt(files.length);
    text = new Text();
    read(text, files[fileIndex]);
    text.breakLines(maxCharsInLine);
    if (!showPolishChars) {
      text.removePolishChars();
    }

    typedText = new Text();
    typedText.add("");
    mistakesCount=0;
    mistakes = new Text();
    mistakes.add("");
  }

  /** Wczytuje kolejne linie z pliku file do tablicy lines */
  public static void read(Text lines, File file) {
    try {
      BufferedReader in = new BufferedReader(new FileReader(file));
      try {
	String s;
	while((s = in.readLine()) != null) {
	  lines.add(s);
	}
      } finally {
	in.close();
      }
    } catch(IOException e) {
      throw new RuntimeException(e);
    }
  }

  public String getAppletInfo() {
    return "Test pr�dko�ci pisania.\nF2 wy��cza/w��cza polskie znaki.";
  }
}

/**
 * Tekst w postaci kolejnych linii umieszczonych w tablicy ArrayList
 */
class Text extends ArrayList<String> {

  public void removePolishChars() {
    for (int i=0; i < size(); i++) {
      set(i, get(i).replace('�', 'a'));
      set(i, get(i).replace('�', 'c'));
      set(i, get(i).replace('�', 'e'));
      set(i, get(i).replace('�', 'l'));
      set(i, get(i).replace('�', 'n'));
      set(i, get(i).replace('�', 'o'));
      set(i, get(i).replace('�', 's'));
      set(i, get(i).replace('�', 'z'));
      set(i, get(i).replace('�', 'z'));

      set(i, get(i).replace('�', 'A'));
      set(i, get(i).replace('�', 'C'));
      set(i, get(i).replace('�', 'E'));
      set(i, get(i).replace('�', 'L'));
      set(i, get(i).replace('�', 'N'));
      set(i, get(i).replace('�', 'O'));
      set(i, get(i).replace('�', 'S'));
      set(i, get(i).replace('�', 'Z'));
      set(i, get(i).replace('�', 'Z'));
    }
  }

  public void breakLines(int lineLength) {
    int eolIndex=0;
    for (int i=0; i < size(); i++) {
      for (int j=1; j < get(i).length() && j <= lineLength; j++) {
	if (get(i).charAt(j) == ' ' || get(i).charAt(j) == '\t') {
	  eolIndex=j;
	}
	if (j == lineLength) { // lamiemy linie
	  add(i+1, get(i).substring(eolIndex+1));
	  set(i, get(i).substring(0, eolIndex));
	}
      }
    }
  }

  /** Dlaczego takiej metody nie ma w bibliotece standardowej? */
  public String getLast() {
    return get(size()-1);
  }

  public void setLast(String s) {
    set(size()-1, s);
  }
}

