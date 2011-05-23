jQuery(document).ready(function(){
	createTree(jQuery("#apptree"),window.catstree);

	jQuery("#apptree").bind("click",function(e){
		var el = $(e.target);
		if(el.is("input[type=checkbox]")){
			var t = el.prop("checked");
			el.closest("li").find("input[type=checkbox]").prop("checked",t);
			if(t){
			el.closest("li").parents("li").children("span").children("input[type=checkbox]").prop("checked",true);
			}
		}		
	});

	var html = [];
	for(var i in window.pages){
		var p = window.pages[i];
		html.push("<li><span>");
		html.push("<div class='selectimg'>",getImages("page",p.ID),"</div> <input class='pagCheck' type='checkbox' name='pages[]' value='",p.ID,"' />");
		html.push(p.post_title,"</span></li>");
	}
	jQuery("#apppage").html(html.join(""));

	restoreSelection(jQuery("#apptree"),"cats");
	restoreSelection(jQuery("#apppage"),"pages");

	jQuery("#save").bind("click",function(e){
		var tree = getTree(jQuery("#apptree"));
		jQuery("#appform").children("input[name=tree]").val($.base64Encode($.toJSON(tree)));
		jQuery("#appform").submit();
	});


	jQuery("td.extraimg").each(function(){
		var n = $(this).data("name");
		var im = getImages(n,"");
		$(this).html(im);
		if(window.extrasimg[n]){
			$(this).find("select").val(window.extrasimg[n]);
		}else{
			$(this).find("option:contains(rss)").attr("selected","selected");
		}
		$(this).find("select").msDropDown();
	});
});


function restoreSelection(place,type){

	var inputs=place.find("input[type=checkbox]");
	var c = window[type+"checked"];
	for(var i in c){
		var id = c[i];
		inputs.filter("[value="+id+"]").prop("checked",true);
	}

	inputs=place.find("select");
	inputs.children("option:contains(rss)").attr("selected","selected");

	var im = window[type+"img"];
	for(var i in im){
		//console.log(i);
		var sel = inputs.filter("[name="+i+"]");
		if(sel.length > 0){
			sel.val(im[i]);
			/*
			var opt = sel.children("option:selected");
			if(opt.length > 0){
				//console.log(opt);
			}
			*/
		}
	}
	try{
		inputs.msDropDown();
	} catch(e) {
		//console.log(e);
		//alert(e.message);
	}	

}

function createTree(place,cat){
        for(var i in cat){
                var html = [];
                html.push("<li nome='",window.cats[i]['name'],"' ");
		html.push("link='",window.catsfeed[i],"' ");
		html.push("descrizione='",window.cats[i]['description'],"' >");
		html.push("<span><div class='selectimg'>",getImages("cat",i),"</div> <input class='catCheck' type='checkbox' name='cats[]' value='",i,"'>",window.cats[i]['name']);
                html.push("</span><ul></ul></li>");
                var nl = jQuery(html.join("")).appendTo(place);
                createTree(nl.children("ul"),cat[i]);
        }
}

function getTree(place){
	var res = [];
	jQuery(place).children("li").each(function(){
		var el = jQuery(this);
		var eld = el.children("span");
		if(eld.children("input[type=checkbox]").prop("checked")){
			var d = {};
			d['nome']=el.attr("nome");
			d['descrizione']=el.attr("descrizione");
			d['option']={
				"type":"xml",
				"urltype":"news",
				"url":el.attr("link")
			};
			d['img']=eld.children("div").find("select").val();
			d['child']=getTree(el.children("ul"));
			res.push(d);
		}
	});

	return res;
}

function getImages(type,id){

	var html = ["<select name='",type,"img",id,"'>"];

	for(var i in window.images){
		img = window.images[i];
		var imgname = img.split("/");
		imgname = imgname[imgname.length-1].split(".");
		imgname = imgname[0];
		//html.push("<option style='background-image:url(http://www.apps-builder.com",img,");");
		//html.push("width:50px;height:50px' ");
		//html.push("<option ");
		html.push("<option title='http://www.apps-builder.com",img,"'  ");
		html.push(" value='",img,"'>",imgname,"</option>");
	}
	html.push("</select>");
	return html.join("");

}

