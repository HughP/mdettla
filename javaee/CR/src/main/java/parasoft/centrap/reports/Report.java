package parasoft.centrap.reports;

public abstract class Report {

	private static final String EMPTY_RESULTS = "Empty results.";
	public static final Report EMPTY = new Report() {
		{
			results = EMPTY_RESULTS;
		}
		@Override
		protected String computeResults() {
			return EMPTY_RESULTS;
		}
	};

	protected ReportFilter filter;
	protected String results;

	/**
	 * Potentially expensive operation.
	 */
	protected abstract String computeResults();

	public void setFilter(ReportFilter filter) {
		this.filter = filter;
	}

	public void start() {
		if (filter == null) {
			throw new IllegalStateException(
					"Filter cannot be null after report is started.");
		}
		results = computeResults();
	}

	public String getHtmlResults() {
		checkResultsNotNull();
		return "Report in HTML format.<br />\n" +
			results.replace("\n", "<br />\n");
	}

	public String getPlainTextResults() {
		checkResultsNotNull();
		return "Report in plain text format.\n" + results;
	}

	public String getCsvResults() {
		checkResultsNotNull();
		return "Report in CSV format.\n" + results;
	}

	private void checkResultsNotNull() {
		if (results == null) {
			throw new IllegalStateException(
					"Results cannot be null before conversion.");
		}
	}
}
