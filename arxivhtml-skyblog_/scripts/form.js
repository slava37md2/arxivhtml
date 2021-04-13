var ie=document.all?1:0;
var ns=document.getElementById&&!document.all?1:0;

function SmilesTable()
{
	if(ie)
	{
		if(document.all.SmilesTr.style.display=="none")
		{
		document.all.SmilesText.innerText="Не добавлять комментарий";
		document.all.SmilesTr.style.display='';
		}

		else
		{
		document.all.SmilesText.innerText="Добавить комментарий";
		document.all.SmilesTr.style.display='none';
		}
	}

	else if(ns)
	{

		if(document.getElementById("SmilesTr").style.display=="none")
		{
		document.getElementById("SmilesText").innerHTML="Не добавлять комментарий";
		document.getElementById("SmilesTr").style.display='';
		}

		else
		{
		document.getElementById("SmilesText").innerHTML="Добавить комментарий";
		document.getElementById("SmilesTr").style.display='none';
		}
	}

	else
	alert("Ваш браузер не поддерживается!");
}

function InsertSmile(SmileId)
{
	if(ie)
	{
	document.all.message.focus();
	document.all.message.value+=" "+SmileId+" ";
	}


	else if(ns)
	{
	document.forms['guestbook'].elements['message'].focus();
	document.forms['guestbook'].elements['message'].value+=" "+SmileId+" ";
	}

	else
	alert("Ваш браузер не поддерживается!");
}

function InsertName(NameId)
{
	if(ie)
	{
	document.all.message.focus();
	document.all.message.value+=" "+NameId+", ";
	}


	else if(ns)
	{
	document.forms['guestbook'].elements['message'].focus();
	document.forms['guestbook'].elements['message'].value+=" "+NameId+", ";
	}

	else
	alert("Ваш браузер не поддерживается!");
}
function inputBG( obj, on )
 {
	if(on) obj.className='bginp1';
	 else if( !obj.value ) obj.className='bginp2';
 }