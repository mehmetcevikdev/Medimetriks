var elems = $(".ilgini-cekebilir-inside a");
if (elems.length >= 2) {
  var keep1, keep2;

  do {
    keep1 = Math.floor(Math.random() * elems.length);
    keep2 = Math.floor(Math.random() * elems.length);
  } while (keep2 === keep1 || $(elems[keep1]).text() === $(elems[keep2]).text());

  for (var i = 0; i < elems.length; ++i) {
    if (i !== keep1 && i !== keep2) {
      $(elems[i]).hide();
    }
  }
} else {
  console.log("Yetersiz sayıda öğe.");
}
