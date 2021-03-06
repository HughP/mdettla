package mdettla.fuzzy;

import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

import mdettla.util.Function;

public class SimpleFuzzyRules {

	private static final double ALPHA = 10;

	private final double[][] dataIn;
	private final Function function;
	private final double[] dataOut;
	private final Map<FuzzySet, Double> rules;

	public SimpleFuzzyRules(
			double[][] dataIn, Function function, List<FuzzySet> fuzzySets) {
		this.function = function;
		this.dataIn = dataIn;
		dataOut = getDataOutputs();
		rules = generateRules(fuzzySets);
	}

	private double[] getDataOutputs() {
		double[] dataOut = new double[dataIn.length];
		for (int i = 0; i < dataIn.length; i++) {
			dataOut[i] = function.evaluate(dataIn[i]);
		}
		return dataOut;
	}

	private Map<FuzzySet, Double> generateRules(List<FuzzySet> fuzzySets) {
		Map<FuzzySet, Double> rules = new LinkedHashMap<FuzzySet, Double>();
		double sum;
		for (FuzzySet fuzzySet : fuzzySets) {
			sum = 0;
			double b = 0;
			for (int j = 0; j < dataIn.length; j++) {
				double membershipMul = 1;
				for (int k = 0; k < dataIn[j].length; k++) {
					double membership = fuzzySet.membership(dataIn[j][k]);
					membershipMul *= membership;
				}
				double w = Math.pow(membershipMul, ALPHA);
				sum += w;
				double y = dataOut[j];
				b += w * y;
			}
			b /= sum;
			rules.put(fuzzySet, b);
		}
		return rules;
	}

	public double getOutput(double[] x) {
		double nominator = 0;
		double denominator = 0;
		for (Map.Entry<FuzzySet, Double> rule : rules.entrySet()) {
			FuzzySet fuzzySet = rule.getKey();
			double b = rule.getValue();
			double membershipMul = 1;
			for (int i = 0; i < x.length; i++) {
				double membership = fuzzySet.membership(x[i]);
				membershipMul *= membership;
			}
			nominator += membershipMul * b;
			denominator += membershipMul;
		}
		return nominator / denominator;
	}

	public double getError(double[][] xs) {
		double error = 0;
		for (double[] x : xs) {
			double expected = function.evaluate(x);
			double actual = getOutput(x);
			error += Math.pow(actual - expected, 2);
		}
		return Math.sqrt(error);
	}
}
