<?php /* Smarty version 2.6.18, created on 2010-02-16 17:22:57
         compiled from /home/likethewind/wx/app/view/admin/passw.tpl */ ?>
<?php echo '(function() {
function randomChar(l,type){
	var x;
   if (type) {
   	x = "0123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
   }
   else {
   	x = "!#$%&\'()=-~^|\\"\'@`{}:*;[]/?<>,.0123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
   }
   var   tmp="";
   for(var   i=0;i<   l;i++)   {
    tmp   +=   x.charAt(Math.ceil(Math.random()*100000000)%x.length);
   }
   return   tmp;
}

function randomPass(){
	var passwordlist=new Array("lank","lapidary","lapse","larch","lard","largesse","lark","larva","laryngitis","larynx","lascivious","lash","lassitude","lasso","latent","latency","lathe","latitude","lattice","laud","laudable","laudatory","laurel","laurels","lava","lave","lax","laxity","laxative","layman","leach","leaflet","leakage","lean","lease","leaven","lecherous","lechery","ledger","leer","leeward","legacy","legend","legerdemain","legible","legion","legislate","legislature","legitimate","lengthy","lenient","lenience","leonine","leprosy","lesion","lessee","lethal","lethargy","leucocyte","levee","leviathan","levitate","levity","levy","lewd","lexical","lexicographer","lexicon","liability","liable","liaison","libation","libel","libellous","liberality","liberated","libertine","libido","libidinous","libretto","licence","licentious","licit","lido","lien","ligature","ligneous","lilliputian","limb","limber","limbo","limerick","limn","limnetic","limousine","limpid","lineal","linear","linger","lingering","lingual","linguistics","linoleum","lint","lionize","liquefy","liquidate","liquidation","lissom","listless","literal","literati","lithe","litigant","litigious","litter","litterbin","littoral","liturgy","liturgical","livable","lively","liverish","livid","loaf","loam","loathe","loathsome","lobby","lobe","lobster","locale","locomotion","locomotive","locus","locust","locution","lodge","lodger","loft","lofty","log","logistics","logjam","loiter","loll","longevity","longitude","longueur","loom","loon","loop","loot","lope","loquacious","lore","lottery","lounge","lounger","lout","loutish","lowbred","lubricant","lubricious","lucrative","lucre","lucubrate","lucubration","lugubrious","lukewarm","lullaby","lumber","luminary","luminous","lump","lumpish","lunacy","lunatic","lurch","lure","lurk","luscious","lust","lusty","lustre","lustrous","luxuriant","lynch","lyric","macabre","mace","macerate","machination","macrocosm","maddening","madrigal","maelstrom","maestro","magenta","magisterial","magistrate","magistracy","magnanimous","magnate","magnetism","magnify","magnification","magniloquent","magnitude","magpie","maim","makeshift","maladroit","malapropism","malcontent","malcontented","malediction","malevolent","malfunction","malice","malicious","malign","malignant","malignity","malinger","malleable","mallet","malnutrition","malodorous","maltreat","mammal","manacle","mandate","mandatory","maneuver","maneuverable","mangle","mania","maniacal","manifest","manifesto","manifold","manipulative","mannequin","mansion","mantle","manumit","manuscript","maple","mar","maraud","mare","margarine","marginal","marine","mariner","marionette","marital","marrow","marsh","marsupial","martinet","martyr","mash","mask","mason","masonry","masquerade","massacre","massive","mast","masticate","matador","materialize","matriarchy","matrix","mattress","maturity","maudlin","maul","maverick","mawkish","maxim","mayhem","maze","meadow","meager","meander","measles","measured","medal","meddlesome","median","mediate","medieval","mediocre","mediocrity","meditative","medium","medley","megalomania","melancholy","mellifluous","melodrama","melody","melodious","melon","membrane","memento","menace","mendacity","menial","mentor","merchandise","mercurial","mere","meretricious","meritorious","mermaid","mesa","mesmerize","metabolism","metamorphosis","metaphor","metaphorical","metaphysics","meteoric","meticulous","mettle","mettlesome","miasma","microbe","microscopic","midget","mien","migrant","mildew","milieu","militant","miller","millinery","mime","mimic","mimicry","minaret","minatory","mince","miniature","minion","minnow","minuet","minutia","mirage","mire","mirth","misanthrope","miscellany","miscellaneous","mischievous","misconstrue","miscreant","mishap","missile","mistimed","mistral","mists","mite","mitigate","mitten","mnemonics","moan","moat","mock","moderate","moderator","modicum","modify","modification","modish","modulate","mogul","moiety","molar","molest","mollify","mollusk","mollycoddle","momentary","momentous","momentum","monarch","monastery","monasticism","mongrel","monogamy","monograph","monolithic","monologue","monopoly","monotonous","monsoon","monster","monstrous","moor","mope","morale","moralist","moralistic","morass","moratorium","morbid","morbidity","mordant","mores","moribund","moron","morose","morphemics","morsel","mortar","mortgage","mortify","mortification","mortuary","mosaic","mote","motif","motivate","motivation","motley","mottled","motto","mountebank","mourn","mournful","movement","muddle","muffle","muffler","muggy","multifarious","multitude","mundane","munificent","muniments","munitions","murky","murmur","muse","muster","mutation","mute","mutilate","mutineer","mutinous","mutton","muzzy","myopia","myriad","myth","mythology","nadir","nag","naivete","nap","narcissism","nasal","nascent","nativity","natty","nausea","nauseate","nautical","nave","nebula","nebulous","necessitous","necromancy","necropolis","needle","nefarious","negate","negation","negligence","negligible","negotiable","nemesis","neolithic","neologism","neonate","neophyte","nephritis","nepotism","nerveless","nestle","nestling","nethermost","nettle","neurology","neurosis","neurotic","neutral","neutralize","nexus","nib","nibble","niche","nick","nicotine","niggard","niggardly","niggling","nightmare","nihilism","nimble","nippers","nipping","nirvana","nitpick","nocturnal","noisome","nomad","nomadic","nomenclature","nominal","nomination","nonchalance","nonchalant","noncommittal","nonconformist","nonconformity","nondescript","nonentity","nonesuch","nonflammable","nonobservance","nonpareil","nonplus","nonskid","nonviolent","noose","norm","normative","nostalgia","nostrum","notability","notched","notify","notoriety","notorious","novelettish","novelty","novice","novocaine","noxious","nuance","nubile","nude","nudity","nudge","nugatory","nullify","nullity","numb","numerology","numinous","numismatic","numismatist","nunnery","nuptial","nuptials","nymph","oafish","oak","oar","oasis","oath","obdurate","obedient","obeisance","obese","obesity","obfuscate","objection","objectionable","oblation","obligation","obligatory","obliging","oblique","obliterate","oblivion","oblivious","obloquy","obnoxious","obscure","obscurity","obsequies","obsequious","observance","obsession","obsolescent","obsolete","obstacle","obstetrics","obstinate","obstreperous","obstruct","obstruction","obtrude","obtrusive","obtuse","obverse","obviate","occidental","occult","occurrence","octogenarian","ocular","oculist","oddments","ode","odious","odium","odoriferous","oesophagus","offense","offensive","officious","ogle","ointment","olfactory","oligarchy","omen","ominous","omission","omnipotent","omniscient","omnivorous","onerous","onlooker","onslaught","ontology","onus","ooze","opalescent","opaque","opacity","operetta","operative","ophthalmology","opiate","opinionated","opponent","opportune","oppressive","opprobrious","opprobrium","optimism","optimum","optional","opulent","opulence","oracle","oracular","oration","oratorio","orchid","ordain","ordeal","ordinance","ordination","ordnance","ore","organism","orient","orientation","orifice","originality","ornate","ornithology","orotund","orthodontics","orthodox","orthodoxy","orthopedics","oscillate","oscillation","osmosis","osseous","ossify","ostensible","ostentation","ostracize","ostrich","otiose","outbid","outfox","outgoing","outlandish","outmoded","outrage","outrageous","outset","outskirts","outstrip","outwit","ovation","overact","overbearing","overdose","overhaul","overlap","overreach","override","overriding","overrule","overshadow","overt","overture","overweening","overwhelm","overwhelming","overwrought","owl","oxidize","oyster","pabulum","pachyderm","pacifier","packed","pact","paean","pagan","paganism","pageant","painkiller","pal","palatable","palate","palatial","palaver","paleography","paleolithic","palette","palings","palliate","palliation","pallid","palpable","palpitate","paltry","pamper","pamphlet","pan","panacea","pancreas","pandemic","pandemonium","panegyric","panel","panic","panoply","panorama","pantheon","pantomime","pantry","papyrus","par","parable","paradigm","paradigmatic","paradox","paragon","paralyze","paralysis","paramount","paranoia","paranoid","parasite","parasitic","parch","parchment","parenthesis","pariah","parley","parlous","parochial","parody","paroxysm","parquet","parquetry","parry");
	return passwordlist[Math.ceil(Math.random()*100000000)%passwordlist.length];
}
function returnone(a,b){
	var c;
	if(a){
		c= a;
	}else{
		c= b;
	}
	if(c){
		return prompt("change value of "+c+" to ",c);
	}else{
		return "";
	}
}

var passlist=new Array();
var inputname="";
var inputpass="";
'; ?>

<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
passlist[<?php echo $this->_foreach['foo']['iteration']; ?>
]=new Array( "<?php echo $this->_tpl_vars['item'][1]; ?>
","<?php echo $this->_tpl_vars['item'][2]; ?>
","<?php echo $this->_tpl_vars['item'][3]; ?>
" );
<?php endforeach; endif; unset($_from); ?>

<?php echo '
for ( key in passlist ) {
    domain=passlist[key][0];
	if(window.document.location.href.indexOf(domain)>=0){
		inputname=passlist[key][1];
		inputpass=passlist[key][2];
		break;
	}
}


//take care of <input type=
var nextdocument;
var allinput=document.getElementsByTagName("input");
var testpass="'; ?>
<?php echo $this->_tpl_vars['password']; ?>
<?php echo '";
var alertpass=true;
var dumpstr="";


if(inputname){
	for(i=0;i<allinput.length;i++){
		if (allinput[i].getAttribute(\'type\')!=\'text\') {
			//continue;
		}
		if(document.activeElement == allinput[i]){
			nextdocument=allinput[i+1];
			break;
		}
	}
	if(!inputpass){
		inputpass="";
	}
	if(inputname.indexOf("@")>=0){
		inputname=inputname+"gmail.com";
	}
	document.activeElement.value=inputname;//window.document.location.href;
	if(inputpass.indexOf("*")<0){
		nextdocument.value=inputpass;
	}
	nextdocument.focus();//document.getElementById(\'text1\').focus();
}else{
	var checkedname=new Array();
	for(i=0;i<allinput.length;i++){		
		if(true){
			dumpstr+=allinput[i].name+":"+allinput[i].getAttribute(\'type\')+":"+allinput[i].disabled+" ";		
			if (allinput[i].getAttribute(\'type\')==\'text\') {
				if(allinput[i].name.indexOf(\'email\')>=0){
					allinput[i].value="thanks20091111@163.com";
				}else if(allinput[i].name.indexOf(\'name\')>=0){
					allinput[i].value="'; ?>
<?php echo $this->_tpl_vars['username']; ?>
<?php echo '";;
				}else{
					if(!allinput[i].value){					
						allinput[i].value=returnone(allinput[i].name,allinput[i].id);
					}
				}
			}else if(allinput[i].getAttribute(\'type\')==\'password\') {			
				allinput[i].value=testpass;
				if(alertpass){
					alertpass=false;
					prompt("password is ",testpass);
				}
			}else if(allinput[i].getAttribute(\'type\')==\'radio\') {
				if(!checkedname[allinput[i].name]){							
					allinput[i].checked=true;
					checkedname[allinput[i].name]=true;				
				}			
			}else if(allinput[i].getAttribute(\'type\')==\'checkbox\') {			
				allinput[i].checked=true;						
			}else{
				//alert(allinput[i].getAttribute(\'type\'));
				if(!allinput[i].value){
					allinput[i].value=returnone(allinput[i].name,allinput[i].id);
				}
			}
		}
	}
	
	//take care of <select 
	var allselect=document.getElementsByTagName("select");
	for(i=0;i<allselect.length;i++){
		allselect[i].options[1].selected = true;   
	}
	
	//textarea <textarea
	var alltextarea=document.getElementsByTagName("textarea");
	for(i=0;i<alltextarea.length;i++){
		if(!alltextarea[i].value){
			alltextarea[i].value=returnone(alltextarea[i].name,alltextarea[i].id)+":"+randomPass()+" "+randomChar(2,1);  
		}else{
			//alert(alltextarea[i].value);
		}
	}
	
	//form <form
	var alltform=document.getElementsByTagName("form");
	var tempurl;
	for(i=0;i<alltform.length;i++){
		tempurl=prompt("input action url for form: "+alltform[i].name,alltform[i].action);
		if(tempurl){
			alltform[i].action=tempurl;
		}   
	}	
}



document.title=dumpstr;


})();'; ?>
