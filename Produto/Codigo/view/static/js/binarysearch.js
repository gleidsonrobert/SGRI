//******************************************************************************
// @name:          binarysearch.js
// @purpose:     Script que faz busca por strings em uma lista.
// @example:     multiBinaryMatch(lista, 'palavra chave', 1, 1);
// @return:        posições da lista que contém a string procurada.
//******************************************************************************

function multiBinaryMatch(array, find, continuous, subset) {
    if (!array ||
        typeof array != "object" ||
        !array.length || typeof find == "undefined") {
        return null;
    }
    if (array.length == 1) {
        return array[0] == find ? 0 : null;
    }
	find = find.toLowerCase();
    continuous = continuous ? new Array(0) : null;
    subset = subset && !isNaN(parseFloat(subset)) ? parseFloat(subset) : 50;
    subset = subset > array.length || subset <= 0 ? array.length : subset;
    fragments = Math.round(array.length / subset);
    var indexes = new Array(0);
    for (var i = 0, head = 0, tail = subset - 1; i < fragments; i++, head += subset, tail += subset) {
        indexes[++indexes.length - 1] = new Array(head, tail);
    }
    indexes[indexes.length - 1][1] = array.length - 1;
    var midPoint2 = Math.floor((indexes[indexes.length - 1][1] - indexes[indexes.length - 1][0]) / 2) + 1;
    for (var i = 0; i < midPoint2; i++) {
        if (array[indexes[indexes.length - 1][0]].toLowerCase().indexOf(find) != -1) {
            if (!continuous) {
                return indexes[indexes.length - 1][0];
            } else {
                continuous[++continuous.length - 1] = indexes[indexes.length - 1][0];
            }
        } else if (array[indexes[indexes.length - 1][1]].toLowerCase().indexOf(find) != -1) {
            if (!continuous) {
                return indexes[indexes.length - 1][1];
            } else {
                continuous[++continuous.length - 1] = indexes[indexes.length - 1][1];
            }
        }
        indexes[indexes.length - 1][0]++;
        indexes[indexes.length - 1][1]--;
    }
    indexes.pop();
    var midPoint = Math.floor((indexes[0][1] - indexes[0][0]) / 2) + 1;
    for (var i = 0; i < midPoint; i++) {
        for (var A = 0; A < indexes.length; A++) {
            if (array[indexes[A][0]].toLowerCase().indexOf(find) != -1) {
                if (!continuous) {
                    return indexes[A][0];
                } else {
                    continuous[++continuous.length - 1] = indexes[A][0];
                }
            } else if (array[indexes[A][1]].toLowerCase().indexOf(find) != -1) {
                if (!continuous) {
                    return indexes[A][1];
                } else {
                    continuous[++continuous.length - 1] = indexes[A][1];
                }
            }
            indexes[A][0]++;
            indexes[A][1]--;
        }
    }
    return continuous && continuous.length ? continuous : null;
}