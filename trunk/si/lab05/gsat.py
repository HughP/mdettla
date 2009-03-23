#!/usr/bin/env python
# -*- coding: ISO-8859-2 -*-

"""Algorytm GSAT, sprawdzaj�cy spe�nialno�� formu�y.

Podana formu�a musi by� w koniunkcyjnej postaci normalnej (CNF).
Przyk�ad: (p V q) & (~q V r V ~s) & (s V ~t)

"""

import sys
import random


class Literal:
    """Atom - pojedynczy symbol lub jego zaprzeczenie."""
    def __init__(self, symbol, not_negated):
        self.symbol = symbol
        self.not_negated = not_negated

    def __str__(self):
        if self.not_negated:
            return self.symbol
        else:
            return '~' + self.symbol

    def evaluate(self, value):
        """Zwr�� warto�� atomu dla podanego warto�ciowania."""
        return (self.not_negated and value) or \
                (not self.not_negated and not value)


class Formula:
    """Formu�a w postaci CNF."""
    def __init__(self, input):
        self.CNF = []
        self.symbols = set()
        input = input.strip().replace(' ', '').\
                replace('(', '').replace(')', '')
        conjunctions = input.split('&')
        for conjunction in conjunctions:
            self.CNF.append([])
            disjunction = conjunction.split('V')
            for literal_str in disjunction:
                if literal_str.startswith('~'):
                    literal = Literal(literal_str[-1], False)
                else:
                    literal = Literal(literal_str[-1], True)
                self.CNF[-1].append(literal)
                self.symbols.add(literal_str[-1])

    def __str__(self):
        s = ''
        for disjunction in self.CNF:
            s += '('
            for literal in disjunction:
                s += str(literal) + ' V '
            s = s[:-3]
            s += ') & '
        return s[:-3]

    def evaluate(self, evaluation):
        """Czy formu�a jest spe�niona dla podanego warto�ciowania."""
        return self.satisfied_clauses_count(evaluation) == len(self.CNF)

    def satisfied_clauses_count(self, evaluation):
        """Zwr�� liczb� dysjunkcji spe�nionych dla podanego warto�ciowania.

        evaluation - warto�ciowanie: s�ownik, w kt�rym kluczami s� symbole,
            a warto�ciami ich warto�ciowania (True/False)

        """
        satisfied_clauses = 0
        for disjunction in self.CNF:
            for literal in disjunction:
                if literal.evaluate(evaluation[literal.symbol]):
                    satisfied_clauses += 1
                    break
        return satisfied_clauses


def gsat(formula):
    """Algorytm GSAT."""
    evaluation = {}
    for symbol in formula.symbols:
        evaluation[symbol] = random.choice([True, False])
    # TODO
    if formula.evaluate(evaluation):
        return evaluation
    else:
        return None


if __name__ == '__main__':
    formula = Formula(raw_input())
    print formula
    evaluation = gsat(formula)
    if evaluation:
        print u'Podana formu�a jest spe�niona dla warto�ciowania:'
        print evaluation
    else:
        print u'Nie znaleziono warto�ciowana spe�niaj�cego formu��.'

