/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 
 * @param {String[]} table - lista de las columnas de la tabla
 * @param {String[][]} args - matriz con los objetos que deben salir en la table
 *  donde en la primera posicion del cada objeto debe ir el id de la fila y luego
 *   el valor q corresponde a cada columna
 * @returns {String} el html de la tabla 
 */
function generateTable(table, args){
    var c = new Array();
    c.length;
    var h = "<tr>";
    for(var i = 0; i < table.length; i++){
        h += "<th>"+ table[i] +"</th>";
    }
    h += "</tr>";
    for(var i = 0; i < args.length; i++){
         h += "<tr id=\""+args[i][0]+"\">";
        for (var j = 1; j < args[i].length; j++){
            h += " <td>"+args[i][j]+"</td>";
        }
        h += "</tr>";
    }
    return h;
}

function generateRow(args){
    
    var h = "<tr id=\"" + args[0] + "\">";
    for(var i = 1; i < args.length; i++){
        h += " <td>" + args[i] + "</td>";   
    }
    h += "</tr>";
    return h;
}


