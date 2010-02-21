package tt {

    import flash.display.DisplayObjectContainer;
    import flash.display.Sprite;
    import flash.geom.Rectangle;
    import flash.text.TextField;
    import flash.text.TextFormat;

    public class TypingArea extends Sprite {

        public static const MAX_LINES:int = 12;
        public static const MAX_TYPING_LINES:int = 3;
        public static const LINE_HEIGHT:int = 22;
        public static const TOP_MARGIN_TEXT:int = 4;
        public static const TOP_MARGIN_WRITTEN:int = 24;
        public static const TEXT_TO_TYPE_COLOR:uint = 0x000000;
        public static const WRITTEN_TEXT_COLOR:uint = 0x0000C0;

        // text to type
        private var visibleTextLines:Array /* of TextField */;
        // text typed in by the user
        private var visibleWrittenLines:Array /* of TextField */;

        private var welcomeText:TextField;
        private var bounds:Rectangle;

        public function TypingArea(width:int, height:int,
                backgroundColor:uint = 0xFFFFFF, borderColor:uint = 0x000000) {
            bounds = new Rectangle(0, 0, width, height);
            drawBounds(backgroundColor, borderColor);

            visibleTextLines = initVisibleTextLines();
            visibleWrittenLines = initVisibleWrittenLines();
            welcomeText = createWelcomeText();
            addChild(welcomeText);
        }

        public function draw(typingTestModel:TypingTestModel):void {
            var startLine:int =
                typingTestModel.writtenLines.length - MAX_TYPING_LINES;
            if (startLine < 0) {
                startLine = 0;
            }
            var endLine:int = startLine + MAX_TYPING_LINES - 1;
            if (endLine > typingTestModel.writtenLines.length - 1) {
                endLine = typingTestModel.writtenLines.length - 1;
            }

            drawTextLines(typingTestModel.textLines, startLine, endLine);
            drawWrittenLines(typingTestModel.writtenLines,
                    typingTestModel.mistakes, typingTestModel.corrections,
                    typingTestModel.isMistakeMade, startLine, endLine);
        }

        public function removeWelcomeText():void {
            if (contains(welcomeText)) {
                removeChild(welcomeText);
            }
        }

        private function initVisibleTextLines():Array /* of TextField */ {
            var visibleTextLines:Array /* of TextField */ = [];
            var yShift:int = TOP_MARGIN_TEXT;
            for (var i:int = 0; i < MAX_LINES; i++) {
                var line:TextField = createLine(yShift, TEXT_TO_TYPE_COLOR);
                visibleTextLines.push(line);
                addChild(line);
                yShift += LINE_HEIGHT;
            }
            return visibleTextLines;
        }

        private function initVisibleWrittenLines():Array /* of TextField */ {
            var visibleWrittenLines:Array /* of TextField */ = [];
            var yShift:int = TOP_MARGIN_WRITTEN;
            for (var i:int = 0; i < MAX_LINES; i++) {
                var line:TextField = createLine(yShift, WRITTEN_TEXT_COLOR);
                visibleWrittenLines.push(line);
                addChild(line);
                yShift += LINE_HEIGHT;
            }
            return visibleWrittenLines;
        }

        private function drawTextLines(textLines:Array /* of String */,
                startLine:int, endLine:int):void {
            var visibleIndex:int = 0;
            var i:int;
            for (i = startLine; i <= endLine; i++) {
                visibleTextLines[visibleIndex].text = textLines[i];
                visibleIndex += 1;
                visibleTextLines[visibleIndex].text = "";
                visibleIndex += 1;
            }
            for (i = endLine + 1; i < textLines.length
                    && i < endLine + 1 + MAX_LINES
                        - 2 * (1 + endLine - startLine); i++) {
                visibleTextLines[visibleIndex].text = textLines[i];
                visibleIndex += 1;
            }
            while (visibleIndex < visibleTextLines.length) {
                visibleTextLines[visibleIndex].text = "";
                visibleIndex += 1;
            }
        }

        private function drawWrittenLines(
                writtenLines:Array /* of String */,
                mistakes:Array /* of Array of Boolean */,
                corrections:Array /* of Array of Boolean */,
                isMistakeMade:Boolean, startLine:int, endLine:int):void {
            var visibleIndex:int = 0;
            for (var i:int = startLine; i <= endLine; i++) {
                var htmlLine:String = "";
                for (var j:int = 0; j < writtenLines[i].length; j++) {
                    var htmlChar:String = writtenLines[i].charAt(j);
                    if (mistakes[i][j]) {
                        htmlChar = "<font color=\"#F00000\"><b>"
                            + htmlChar + "</b></font>";
                    } else if (corrections[i][j]) {
                        htmlChar = "<font color=\"#C000D8\">"
                            + htmlChar + "</font>";
                    }
                    htmlLine += htmlChar;
                }
                visibleWrittenLines[visibleIndex].htmlText = htmlLine;
                visibleIndex += 1;
                visibleWrittenLines[visibleIndex].htmlText = "";
                visibleIndex += 1;
            }
            var cursor:String = '_';
            if (isMistakeMade) {
                cursor = "<font color=\"#F00000\">" + cursor + "</font>";
            }
            visibleWrittenLines[visibleIndex - 2].htmlText += cursor;
            while (visibleIndex < visibleWrittenLines.length) {
                visibleWrittenLines[visibleIndex].htmlText = "";
                visibleIndex += 1;
            }
        }

        private function createLine(yShift:int, color:uint):TextField {
            var format:TextFormat = new TextFormat();
            format.font = "Verdana";
            format.size = 15;
            format.color = color;

            var line:TextField = new TextField();
            line.x = 5;
            line.y = yShift;
            line.defaultTextFormat = format;
            line.text = "";
            line.selectable = false;
            line.width = bounds.width - 2;
            return line;
        }

        private function drawBounds(
                backgroundColor:uint, borderColor:uint):void {
            graphics.clear();
            graphics.lineStyle(1.0, borderColor);
            graphics.beginFill(backgroundColor);
            graphics.drawRect(
                    bounds.left, bounds.top,
                    bounds.width, bounds.height);
            graphics.endFill();
        }

        private function createWelcomeText():TextField {
            var welcomeText:TextField = new TextField();
            welcomeText.htmlText = "<p align=\"center\">"
                + "<font face=\"Verdana\" size=\"15\">"
                + "\n\n\nTest polega na przepisywaniu zadanego tekstu.\n"
                + "Czas jest mierzony od momentu kiedy zaczniesz pisać.\n\n"
                + "</font><font face=\"Verdana\" size=\"18\">"
                + "Kliknij aby rozpocząć.\n"
                + "Powodzenia!\n\n"
                + "</font><font face=\"Verdana\" size=\"14\">"
                + "autor: Michał Dettlaff"
                + "</font></p>";
            welcomeText.width = bounds.width;
            welcomeText.height = bounds.height;
            welcomeText.background = true;
            welcomeText.border = true;
            welcomeText.selectable = false;
            return welcomeText;
        };
    }
}
