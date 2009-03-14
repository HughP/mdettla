#!/usr/bin/env python
# -*- coding: UTF-8 -*-

import sys


usage = u"""\
Rozwiązuje problem N królowych dla szachownicy NxN przy pomocy algorytmu
Depth-First Search z heurystyką.
Użycie: python """ + sys.argv[0] + """ N\
"""

# węzłami są rozwiązania (ustawienia królowych na szachownicy)
open_nodes = [] # tuple: (heurystyka węzła, węzeł do rozwinięcia)
closed_nodes = [] # zbadane węzły
solution = [] # pozycje królowych w kolejnych wierszach szachownicy
calls = 0 # liczba wywołań funkcji dfs()


def queens_solution_dfs(N, w0):
    u"""Znajdź rozwiązanie dodając kolejno wiersze z jedną królową."""
    open_nodes.append((0, [w0]))
    if dfs(N):
        return solution
    else:
        return queens_solution_dfs(N, w0+1) # dla innej pozycji początkowej


def dfs(N):
    u"""Algorytm Depth-First Search przeszukiwania przestrzeni rozwiązań."""
    global solution
    global calls
    calls += 1
    if not open_nodes:
        return False
    node = min(open_nodes) # węzeł o minimalnej heurystyce
    solution = node[1]
    open_nodes.remove(node)
    closed_nodes.append(solution)
    for x in range(N): # pozycja następnej królowej, w następnym wierszu
        if is_square_free(x, len(solution), solution):
            neighbor = solution + [x]
            if neighbor not in closed_nodes:
                open_nodes.append((heuristic(neighbor), neighbor))
    if not len(solution) < N:
        return True
    elif dfs(N):
        return True
    elif solution:
        solution.pop()
        return dfs(N)
    else:
        return False


def heuristic(solution):
    u"""Funkcja oceny (heurystyka): oceń podane rozwiązanie.

    Naszą heurystyką będzie ilość pól, które nie są zagrożone szachowaniem.

    """
    free_squares = 0
    for x in range(N):
        for y in range(len(solution)):
            if is_square_free(x, y, solution, True):
                free_squares += 1
    return free_squares


def is_square_free(x, y, solution, only_diagonally=False):
    u"""Sprawdź czy podane pole nie jest zagrożone szachowaniem."""
    for i, queen in enumerate(solution):
        if only_diagonally:
            if abs(x-queen) == abs(y-i):
                return False
        else:
            if x == queen or abs(x-queen) == abs(y-i):
                return False
    return True


def print_solution(solution):
    line = '+'
    for j in range(N):
        line += '---+'
    for i in range(N):
        print line
        for j in range(N+1):
            print '|',
            if j == solution[i]:
                print 'X',
            else:
                print ' ',
        print
    print line


if __name__ == '__main__':
    try:
        if len(sys.argv) > 1:
            sys.setrecursionlimit(20000)
            N = int(sys.argv[1])
            print_solution(queens_solution_dfs(N, 0))
            print u'Liczba wywołań:', calls
        else:
            print usage
    except ValueError:
        print u'Błąd: parametr musi być liczbą całkowitą.'

