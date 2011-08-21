package mdettla.keyboard.ga;

import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

import mdettla.jga.core.ConcurrentGeneticAlgorithm;
import mdettla.jga.core.GeneticAlgorithm;
import mdettla.jga.core.Specimen;
import mdettla.jga.operators.crossover.CycleCrossover;
import mdettla.jga.operators.mutation.SwapMutation;
import mdettla.jga.operators.selection.MultiobjectiveMajorityTournamentSelection;

public class GAKeyboard {

	private static final int POPULATION_SIZE = 100;
	private static final int GENERATIONS_COUNT = 100;
	private static final int ELITE_SIZE = 2;
	private static final int TOURNAMENT_SIZE = 4;
	private static final double MUTATION_PROBABILITY = .7;
	private static final double CROSSOVER_PROBABILITY = .7;

	public static void main(String[] args) throws IOException {
		TextStatistics stats = getTextStatistics(args);
		List<Specimen> initialPopulation = getInitialPopulation(stats);

		GeneticAlgorithm ga = new ConcurrentGeneticAlgorithm(initialPopulation);
		ga.setMutationOperator(new SwapMutation());
		ga.setMutationProbability(MUTATION_PROBABILITY);
		ga.setCrossoverOperator(new CycleCrossover());
		ga.setCrossoverProbability(CROSSOVER_PROBABILITY);
		ga.setSelectionFunction(new MultiobjectiveMajorityTournamentSelection(TOURNAMENT_SIZE));
		ga.setEliteSize(ELITE_SIZE);
		System.out.println(getInitialParameters(ga) + "\n");

		Specimen best = ga.runEpoch(GENERATIONS_COUNT);

		Specimen random = KeyboardLayout.createRandomInstance(stats);
		random.computeFitness();
		System.out.println("\nLosowy układ:\n" + random);
		System.out.println("\nQWERTY:\n" + KeyboardLayout.getQWERTYLayout(stats));
		System.out.println("\nDvorak:\n" + KeyboardLayout.getDvorakLayout(stats));
		System.out.println("\nNajlepiej przystosowany osobnik:\n" + best);
		compareObjectives((KeyboardLayout) best, KeyboardLayout.getDvorakLayout(stats));
	}

	private static TextStatistics getTextStatistics(String[] texts) throws IOException {
		if (texts.length == 0) {
			texts = new String[] {"src/mdettla/keyboard/ga/resources/en/otoos11.txt"};
		}
		TextStatistics stats = new TextStatistics();
		for (String text : texts) {
			stats.read(new InputStreamReader(new FileInputStream(text)));
		}
		System.out.println("długość analizowanego tekstu: "
				+ stats.getTextLength() + " znaków");
		return stats;
	}

	private static List<Specimen> getInitialPopulation(TextStatistics stats) {
		List<Specimen> initialPopulation = new ArrayList<Specimen>();
		for (int i = 0; i < POPULATION_SIZE; i++) {
			initialPopulation.add(KeyboardLayout.createRandomInstance(stats));
		}
		return initialPopulation;
	}

	private static String getInitialParameters(GeneticAlgorithm ga) {
		StringBuilder sb = new StringBuilder();
		sb.append("rozmiar populacji: " + POPULATION_SIZE + "\n");
		sb.append("ilość iteracji: " + GENERATIONS_COUNT + "\n");
		sb.append("rozmiar elity: " + ga.getEliteSize() + "\n");
		sb.append("rozmiar turnieju: " + TOURNAMENT_SIZE + "\n");
		sb.append("prawdopodobieństwo mutacji: " + ga.getMutationProbability() + "\n");
		sb.append("prawdopodobieństwo krzyżowania: " + ga.getCrossoverProbability() + "\n");
		sb.append("operator mutacji: " +
				ga.getMutationOperator().getClass().getSimpleName() + "\n");
		sb.append("operator krzyżowania: " +
				ga.getCrossoverOperator().getClass().getSimpleName() + "\n");
		sb.append("operator selekcji: " +
				ga.getSelectionFunction().getClass().getSimpleName());
		return sb.toString();
	}

	private static void compareObjectives(KeyboardLayout layout, KeyboardLayout other) {
		for (int i = 0; i < layout.OBJECTIVES.length; i++) {
			System.out.println(String.format("%s: %s (%.3f%%)", layout.OBJECTIVES[i].getName(),
					layout.OBJECTIVES[i].getValue() < other.OBJECTIVES[i].getValue(),
					(1 - layout.OBJECTIVES[i].getValue() / other.OBJECTIVES[i].getValue()) * 100));
		}
	}
}
