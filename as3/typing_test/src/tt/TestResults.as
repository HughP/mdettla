package tt {

    public class TestResults {

        private var mistakesCount:int;
        private var correctionsCount:int;
        private var totalCharsCount:int;
        private var writtenCharsCount:int;
        private var typingTimeInMilliseconds:int;

        public function TestResults(typingTestModel:TypingTestModel) {
            totalCharsCount = 0;
            for each (var textLine:String in typingTestModel.textLines) {
                totalCharsCount += textLine.length + 1; // +1 for Enter key
            }
            writtenCharsCount = 0;
            for each (var writtenLine:String in typingTestModel.writtenLines) {
                writtenCharsCount += writtenLine.length;
            }
            writtenCharsCount += typingTestModel.writtenLines.length - 1;
            if (typingTestModel.isFinished) {
                writtenCharsCount += 1; // +1 for last Enter key
            }
            mistakesCount = countMistakes(typingTestModel);
            correctionsCount = 0;
            for (var i:int = 0; i < typingTestModel.corrections.length; i++) {
                var correctionsLine:Array = typingTestModel.corrections[i];
                for each (var isCorrection:Boolean in correctionsLine) {
                    correctionsCount += isCorrection ? 1 : 0;
                }
            }
            typingTimeInMilliseconds =
                typingTestModel.typingTimeInMilliseconds;
        }

        public function get speed():Number {
            if (writtenCharsCount == 0) {
                return 0;
            }
            return writtenCharsCount / timeMinutes;
        }

        public function get realSpeed():Number {
            if (writtenCharsCount == 0) {
                return 0;
            }
            return (writtenCharsCount - mistakesCount) / timeMinutes;
        }

        public function get correctness():Number {
            if (writtenCharsCount == 0) {
                return 0;
            }
            return (writtenCharsCount - mistakesCount - correctionsCount)
                / writtenCharsCount * 100;
        }

        public function toString():String {
            return "prędkość: " + speed + " znaków/min\n"
                + "realna prędkość " + realSpeed + " znaków/min";
        }

        private static function countMistakes(
                typingTestModel:TypingTestModel):int {
            var mistakesCount:int = 0;
            for (var i:int = 0; i < typingTestModel.mistakes.length; i++) {
                var mistakesLine:Array = typingTestModel.mistakes[i];
                for each (var isMistake:Boolean in mistakesLine) {
                    mistakesCount += isMistake ? 1 : 0;
                }
                if (mistakesLine.length
                        != typingTestModel.textLines[i].length) {
                    if (i < typingTestModel.mistakes.length - 1
                            || typingTestModel.isFinished) {
                        mistakesCount += 1; // +1 for incorrectly typed Enter
                    }
                }
            }
            return mistakesCount;
        }

        private function get timeMinutes():Number {
            return typingTimeInMilliseconds / 1000 / 60;
        }
    }
}
