/*
  <applet width=640 height=480 code="Asteroids.class"></applet>
 */

import java.applet.Applet;
import java.lang.Thread;
import java.lang.Math;
import java.awt.Graphics;
import java.awt.Polygon;
import java.awt.Image;
import java.awt.Color;
import java.awt.event.KeyListener;
import java.awt.event.KeyEvent;
import java.util.LinkedList;
import java.util.Random;
import java.util.Date;

/**
 * Gra Asteroids napisana w Javie.
 *
 * @author Micha� Dettlaff
 * @version 0.5
 */
public class Asteroids extends Applet implements Runnable, KeyListener {
  Thread t;
  boolean threadSuspended;
  int width, height;
  Image bufferImage;
  Graphics buffer;
  int speed;
  boolean up, down, left, right;
  boolean fire;
  LinkedList<Asteroid> asteroids;
  LinkedList<Missile> missiles;
  Spaceship player;

  public void init() {
    t = null;
    width = getWidth();
    height = getHeight();
    bufferImage = createImage(width, height);
    buffer = bufferImage.getGraphics();

    speed = 40; // 1000/speed FPS
    asteroids = new LinkedList<Asteroid>();
    missiles = new LinkedList<Missile>();
    player = new Spaceship(width/2, height/2);

    up = down = left = right = false;
    fire = false;
    addKeyListener(this);
  }

  public void destroy() {
    removeKeyListener(this);
  }

  public void start() {
    if (t == null) {
      t = new Thread(this);
      threadSuspended = false;
      t.start();
    }
    else {
      if (threadSuspended) {
	threadSuspended = false;
	synchronized(this) {
	  notify();
	}
      }
    }
  }

  public void stop() {
    threadSuspended = true;
  }

  void delay(int interval) {
    try {
      t.sleep(interval);
      if (threadSuspended) {
	synchronized(this) {
	  while (threadSuspended) {
	    wait();
	  }
	}
      }
    }
    catch (InterruptedException e) { }
  }

  public void run() {
    for (int i=0; i < 5; i++) {
      asteroids.add(new Asteroid(width, height));
    }
    while (true) {
      repaintBuffer();
      player.update(up, down, left, right, width, height);
      if (fire && player.reloaded()) {
	missiles.add(new Missile(player));
	player.reloadMissile();
      }
      for (int i=0; i < missiles.size(); i++) {
	missiles.get(i).update();
	if (missiles.get(i).isGone()) { missiles.remove(i); }
      }
      for (Asteroid a : asteroids) {
	a.update();
      }
      delay(speed);
    }
  }

  void repaintBuffer() {
    drawFrameInBuffer();
    repaint();
  }

  public void paint(Graphics g) {
    update(g);
  }

  public void update(Graphics g) {
    g.drawImage(bufferImage, 0, 0, this);
    getToolkit().sync();
  }

  void drawFrameInBuffer() {
    buffer.setColor(Color.BLACK);
    buffer.fillRect(0, 0, width, height);
    buffer.setColor(Color.WHITE);
    buffer.drawPolygon(player);
    for (Asteroid a : asteroids) {
      buffer.setColor(Color.BLACK);
      buffer.fillPolygon(a);
      buffer.setColor(Color.WHITE);
      buffer.drawPolygon(a);
    }
    buffer.setColor(Color.WHITE);
    for (Missile m : missiles) {
      buffer.fillOval((int) m.x-2, (int) m.y-2, 4, 4);
    }
  }

  public void keyPressed(KeyEvent e) {
    switch (e.getKeyCode()) {
      case KeyEvent.VK_UP:
	up = true;
	break;
      case KeyEvent.VK_DOWN:
	down = true;
	break;
      case KeyEvent.VK_LEFT:
	left = true;
	break;
      case KeyEvent.VK_RIGHT:
	right = true;
	break;
      case KeyEvent.VK_SPACE:
	fire = true;
	break;
    }
  }

  public void keyReleased(KeyEvent e) {
    switch (e.getKeyCode()) {
      case KeyEvent.VK_UP:
	up = false;
	break;
      case KeyEvent.VK_DOWN:
	down = false;
	break;
      case KeyEvent.VK_LEFT:
	left = false;
	break;
      case KeyEvent.VK_RIGHT:
	right = false;
	break;
      case KeyEvent.VK_SPACE:
	fire = false;
	break;
    }
  }

  public void keyTyped(KeyEvent e) {
  }

  public String getAppletInfo() {
    return "Gra Asteroids napisana w Javie.";
  }
}

class Spaceship extends Polygon {
  final int SIZE = 36;
  final double POWER = 2.0;
  final double MAX_SPEED = 12.0;
  final double HANDLING = 10.0;
  final int RELOAD_TIME = 8; // w klatkach
  double x, y;
  double speedX, speedY;
  double angle;
  int timeUntilReload;
  int width, height; // rozmiar planszy, po ktorej porusza sie statek

  Spaceship(int x, int y) {
    this.x = x;
    this.y = y;
    speedX = 0.0;
    speedY = 0.0;
    angle = 0.0;
    timeUntilReload = 0;
  }

  void update(boolean up, boolean down, boolean left, boolean right,
      int width, int height) {
    double rad = Math.toRadians(angle);
    this.width = width;
    this.height = height;

    if (up) { accelerate(); }
    if (down) { decelerate(); }
    if (left) { turnLeft(); }
    if (right) { turnRight(); }
    // uwaga: os y rosnie w dol, a nie do gory
    x += speedX;
    y -= speedY;
    reset();
    // dziob, lewe skrzydlo, lewy tyl, prawy tyl, prawe skrzydlo
    addPoint((int) (x + SIZE/2 * Math.sin(rad)),
       	(int) (y - SIZE/2 * Math.cos(rad)));
    addPoint((int) (x + SIZE/2 * Math.sin(rad + 0.8 * Math.PI)),
       	(int) (y - SIZE/2 * Math.cos(rad + 0.8 * Math.PI)));
    addPoint((int) (x + SIZE/3 * Math.sin(rad + 0.85 * Math.PI)),
       	(int) (y - SIZE/3 * Math.cos(rad + 0.85 * Math.PI)));
    addPoint((int) (x + SIZE/3 * Math.sin(rad - 0.85 * Math.PI)),
       	(int) (y - SIZE/3 * Math.cos(rad - 0.85 * Math.PI)));
    addPoint((int) (x + SIZE/2 * Math.sin(rad - 0.8 * Math.PI)),
       	(int) (y - SIZE/2 * Math.cos(rad - 0.8 * Math.PI)));
    // zapewnia, ze statek nie wyleci poza plansze
    if (x < 0) { x = width; }
    if (x > width) { x = 0; }
    if (y < 0) { y = height; }
    if (y > height) { y = 0; }
    if (timeUntilReload > 0) {
      timeUntilReload--;
    }
  }

  void accelerate() {
    double rad = Math.toRadians(angle);
    speedX += Math.sin(rad) * POWER;
    speedY += Math.cos(rad) * POWER;
    if (speedX > MAX_SPEED) { speedX = MAX_SPEED; }
    if (speedY > MAX_SPEED) { speedY = MAX_SPEED; }
    if (speedX < -MAX_SPEED) { speedX = -MAX_SPEED; }
    if (speedY < -MAX_SPEED) { speedY = -MAX_SPEED; }
  }

  void decelerate() {
    double rad = Math.toRadians(angle);
    speedX -= Math.sin(rad) * POWER;
    speedY -= Math.cos(rad) * POWER;
    if (speedX > MAX_SPEED) { speedX = MAX_SPEED; }
    if (speedY > MAX_SPEED) { speedY = MAX_SPEED; }
    if (speedX < -MAX_SPEED) { speedX = -MAX_SPEED; }
    if (speedY < -MAX_SPEED) { speedY = -MAX_SPEED; }
  }

  void turnLeft() {
    angle -= HANDLING;
  }

  void turnRight() {
    angle += HANDLING;
  }

  void reloadMissile() {
    timeUntilReload = RELOAD_TIME;
  }

  boolean reloaded() {
    return timeUntilReload == 0;
  }
}

class Missile {
  double speed;
  double x, y;
  double speedX, speedY;
  int width, height; // rozmiar planszy, po ktorej porusza sie pocisk

  Missile(Spaceship ss) {
    speed = ss.MAX_SPEED + 5.0;
    x = ss.x + ss.SIZE/2 * Math.sin(Math.toRadians(ss.angle));
    y = ss.y - ss.SIZE/2 * Math.cos(Math.toRadians(ss.angle));
    speedX = speed * Math.sin(Math.toRadians(ss.angle));
    speedY = speed * Math.cos(Math.toRadians(ss.angle));
    this.width = ss.width;
    this.height = ss.height;
  }

  void update() {
    x += speedX;
    y -= speedY;
  }

  /** Czy pocisk wylecial poza plansze. */
  boolean isGone() {
    return x < 0 || x > width || y < 0 || y > height;
  }
}

class Asteroid extends Polygon {
  final int MAX_VERTICES = 10;
  final int SIZE = 50;
  static Random rand = new Random(new Date().getTime());
  double x, y;
  double angle;
  PointPolar[] shape;
  int vertices; // dla odroznienia od npoints
  double speedX, speedY;
  int width, height;
  double rotation;

  Asteroid(int width, int height) {
    this.width = width;
    this.height = height;
    x = Asteroid.rand.nextInt(width);
    y = Asteroid.rand.nextInt(height);
    angle = Asteroid.rand.nextInt(360);
    speedX = Asteroid.rand.nextInt(7) - 3;
    speedY = Asteroid.rand.nextInt(7) - 3;
    rotation = Asteroid.rand.nextInt(17) - 8;

    vertices = Asteroid.rand.nextInt(MAX_VERTICES - 5) + 5;
    shape = new PointPolar[vertices];
    for (int i=0; i < vertices; i++) {
      int polarLength = Asteroid.rand.nextInt(SIZE - 16) + 16;
      int polarAngle = 360/vertices * i;
      shape[i] = new PointPolar(polarLength, polarAngle);
    }
  }

  void update() {
    double rad = Math.toRadians(angle);
    double radDelta = Math.toRadians(rotation);

    x += speedX;
    y -= speedY;
    angle += rotation;
    reset();
    for (int i=0; i < vertices; i++) {
      double radShape = Math.toRadians(shape[i].angle);
      addPoint((int) (x + shape[i].length * Math.sin(rad+radDelta+radShape)),
	  (int) (y - shape[i].length * Math.cos(rad+radDelta+radShape)));
    }
    // zapewnia, ze obiekt nie wyleci poza plansze
    if (x < 0) { x = width; }
    if (x > width) { x = 0; }
    if (y < 0) { y = height; }
    if (y > height) { y = 0; }
  }
}

/**
 * Przechowuje punkt okreslony przy pomocy wspolrzednych biegunowych.
 */
class PointPolar {
  int length;
  int angle;

  PointPolar(int length, int angle) {
    this.length = length;
    this.angle = angle;
  }

  public boolean equals(Object obj) {
    if (!(obj instanceof PointPolar)) {
      return false;
    }
    PointPolar pp = (PointPolar) obj;
    return (pp.length == length && pp.angle == angle);
  }
}

