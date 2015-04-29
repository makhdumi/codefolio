/**
 *  Author: Enrico Garante
 *  http://alexgorbatchev.com/SyntaxHighlighter/manual/brushes/custom.html
 */
SyntaxHighlighter.brushes.Vhdl = function()
{
  var keywords = 'abs configuration impure null rem type access constant in of report unaffected after disconnect inertial on return units alias downto inout open rol until all else is or ror use and elsif label others select variable architecture end library out severity wait array entity linkage package signal when assert exit literal port shared while attribute file loop postponed sla with begin for map procedure sll xnor block function mod process sra xor body generate nand pure srl buffer generic new range subtype bus group next record then case guarded nor register to component if not reject transport ';
  var functions = ' ';
  this.regexList = [
    { regex: /#.*$/gm,	css: 'comments' }, // one line comments
    { regex: SyntaxHighlighter.regexLib.singleQuotedString, css: 'string' },
    { regex: SyntaxHighlighter.regexLib.doubleQuotedString, css: 'string'},
    { regex: new RegExp(this.getKeywords(keywords), 'gm'), css: 'keyword' }
  ];
};
SyntaxHighlighter.brushes.Vhdl.prototype = new SyntaxHighlighter.Highlighter();
SyntaxHighlighter.brushes.Vhdl.aliases	= ['vhdl', 'vhd'];