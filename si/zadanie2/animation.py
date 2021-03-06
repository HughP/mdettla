#!/usr/bin/env python
# -*- coding: UTF-8 -*-

u"""Animacja pokazująca lądowanie samolotu przez automatycznego pilota."""

__author__ = u'Michał Dettlaff'

from PyQt4 import QtCore, QtGui
import sys

import autopilot


WIDTH = 700
u"""Szerokość okna."""
HEIGHT = 380
u"""Wysokość okna."""


class AnimationWindow(QtGui.QMainWindow):
    def __init__(self, heights):
        QtGui.QMainWindow.__init__(self)
        self.setGeometry(300, 300, WIDTH, HEIGHT)
        self.setWindowTitle(u'Automatyczny pilot')
        self.scene = Scene(self, heights)
        self.setCentralWidget(self.scene)
        self.statusbar = self.statusBar()
        self.connect(self.scene,
                QtCore.SIGNAL('messageToStatusbar(QString)'), self.statusbar,
                QtCore.SLOT('showMessage(QString)'))
        self.scene.start()
        self.center()

    def center(self):
        screen = QtGui.QDesktopWidget().screenGeometry()
        size = self.geometry()
        self.move((screen.width()-size.width())/2,
                (screen.height()-size.height())/2)


class Scene(QtGui.QFrame):
    u"""Obszar na którym będziemy rysować."""
    speed = 50
    ground_level = HEIGHT - 75

    def __init__(self, parent, heights):
        QtGui.QFrame.__init__(self, parent)
        self.timer = QtCore.QBasicTimer()
        self.setFocusPolicy(QtCore.Qt.StrongFocus)
        self.plane_img = QtGui.QImage('plane.png')
        self.heights = heights # wysokości samolotu w kolejnych sekundach
        self.time_count = 0
        self.coord_x = 0 # współrzędna x samolotu
        self.coord_y = 50 # współrzędna y samolotu

    def start(self):
        self.timer.start(Scene.speed, self)

    def paintEvent(self, event):
        painter = QtGui.QPainter(self)
        black = QtGui.QColor(0x000000)
        white = QtGui.QColor(0xFFFFFF)
        grey = QtGui.QColor(0x808080)

        self.drawScene(painter, white, black, grey)

    def timerEvent(self, event):
        if self.heights:
            self.time_count += 1
            self.advanceAgent()
            self.update()
            self.emit(QtCore.SIGNAL('messageToStatusbar(QString)'),
                    u'Czas: ' + str(self.time_count))
            self.heights.pop(0)
        else:
            self.timer.stop()

    def drawScene(self, painter, bg_color, color, ground_color):
        painter.fillRect(0, 0, WIDTH, HEIGHT, bg_color)
        painter.drawImage(self.coord_x - 40, self.coord_y - 20, self.plane_img)
        painter.setPen(color)
        painter.fillRect(0, Scene.ground_level, WIDTH, HEIGHT -
                Scene.ground_level, ground_color)
        painter.drawLine(0, Scene.ground_level, WIDTH - 1, Scene.ground_level)

    def advanceAgent(self):
        u"""Przesuń samolot na następną pozycję."""
        self.coord_x += 3.2
        self.coord_y = (HEIGHT + 50) - self.heights[0] / 2.5


def main(argv):
    app = QtGui.QApplication(sys.argv)

    # wysokości samolotu w kolejnych sekundach
    heights = [h for h, v, f in autopilot.autopilot(
        autopilot.defuzzify_center_of_gravity, .5,
        autopilot.DEFAULT_ITERATIONS_AUTOPILOT)]

    animation = AnimationWindow(heights)
    animation.show()
    sys.exit(app.exec_())


if __name__ == '__main__':
    main(sys.argv)

