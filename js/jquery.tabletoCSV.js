;
(function($) {
    $.fn.tableToCSV = function() {
    	function msieversion() {
		  var ua = window.navigator.userAgent;
		  var msie = ua.indexOf("MSIE ");
		  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer, return true
		  {
		    return true;
		  } else { // If another browser,
		  return false;
		  }
		  return false;
		}
        var clean_text = function(text) {
            text = text.replace(/"/g, '""');
            return '"' + text + '"';
        };
        $(this).each(function() {
            var table = $(this);
            var caption = $(this).find('caption').text();
            var title = [];
            var rows = [];
            $(this).find('tr').each(function() {
                var data = [];
                $(this).find('th').each(function() {
                    var text = clean_text($(this).text());
                    title.push(text);
                });
                $(this).find('td').each(function() {
                    var text = clean_text($(this).text());
                    data.push(text);
                });
                data = data.join(",");
                rows.push(data);
            });
            title = title.join(",");
            rows = rows.join("\n");
            var csv = title + rows;
            var ts = new Date().getTime();
            var blob = new Blob([csv],{type: "text/csv;charset=utf-8;"});
            if (window.navigator.msSaveBlob) { // IE 10+
                if (caption == "") {
                    window.navigator.msSaveBlob(blob, ts + ".csv");
	            } else {
	            	window.navigator.msSaveBlob(blob, caption + "-" + ts + ".csv");
	            }
            }
            else if(msieversion()) {
		        var IEwindow =  window.open();
		        IEwindow.document.write(csv);
		        IEwindow.document.close();
		        if (caption == "") {
		        	IEwindow.document.execCommand('SaveAs', true, ts + ".csv");
	            } else {
	            	IEwindow.document.execCommand('SaveAs', true, caption + "-" + ts + ".csv");
	            }
		        IEwindow.close();
		    } else {
	            var uri = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
	            var download_link = document.createElement('a');
	            download_link.href = uri;
	            if (caption == "") {
	                download_link.download = ts + ".csv";
	            } else {
	                download_link.download = caption + "-" + ts + ".csv";
	            }
	            document.body.appendChild(download_link);
	            download_link.click();
	            document.body.removeChild(download_link);
	        }
        });
    };
})(jQuery);