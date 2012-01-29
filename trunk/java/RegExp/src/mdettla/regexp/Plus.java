package mdettla.regexp;

class Plus implements Expression {

	private final Expression expression;

	public Plus(Expression expression) {
		this.expression = expression;
	}

	@Override
	public boolean match(CharIterator chars) {
		if (!expression.match(chars)) {
			return false;
		}
		return new Star(expression).match(chars);
	}

	@Override
	public boolean equals(Object obj) {
		if (obj == null || getClass() != obj.getClass()) {
			return false;
		}
		Plus other = (Plus) obj;
		return expression.equals(other.expression);
	}

	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result + ((expression == null) ? 0 : expression.hashCode());
		return result;
	}

	@Override
	public String toString() {
		return "(" + expression + ")+";
	}
}
