// canvas 要素
var canvas = document.getElementsByTagName('canvas')[0];
  // Processing のソースコード
var code = "size(400, 400); noStroke(); fill(255, 0, 0, 255 * 0.5); ellipse(200, 150, 200, 200); fill(0, 255, 0, 255 * 0.5); ellipse(250, 250, 200, 200); fill(0, 0, 155, 255 * 0.5); ellipse(150, 250, 200, 200);";
  // Processing 関数を呼び出す
var processing = new  Processing(canvas, code);
