package tt {

    import mx.utils.StringUtil;

    public class Utils {

        private static const PL:String = "ąĄćĆęĘłŁńŃóÓśŚżŻźŹ";
        private static const EN:String = "aAcCeElLnNoOsSzZzZ";

        public static function breakLines(
                text:String, maxLineLength:int):Array /* of String */ {
            const multiSpace:RegExp = / +/g;
            var textLines:Array =
                StringUtil.trim(text.replace(multiSpace, ' ')).split('\n');
            var lineEndIndex:int = 0;
            for (var i:int = 0; i < textLines.length; i++) {
                for (var j:int = 1; j < textLines[i].length
                        && j <= maxLineLength; j++) {
                    if (textLines[i].charAt(j) == ' '
                            || textLines[i].charAt(j) == '\t') {
                        lineEndIndex = j;
                    }
                    if (j == maxLineLength) { // break line
                        textLines.splice(i + 1, 0,
                                textLines[i].substring(lineEndIndex + 1));
                        textLines[i] = textLines[i].substring(0, lineEndIndex);
                    }
                }
            }
            return textLines;
        }

        public static function shavePlChars(withPlChars:String):String {
            var withoutPlChars:String = "";
            for (var i:int = 0; i < withPlChars.length; i++) {
                var c:String = withPlChars.charAt(i);
                var plIndex:int = PL.indexOf(c);
                withoutPlChars += plIndex != -1 ? EN.charAt(plIndex) : c;
            }
            return withoutPlChars;
        }

        public static function containsPlChars(s:String,
                index:int = 0, array:Array = null):Boolean {
            for (var i:int = 0; i < s.length; i++) {
                if (PL.indexOf(s.charAt(i)) != -1) {
                    return true;
                }
            }
            return false;
        }
    }
}