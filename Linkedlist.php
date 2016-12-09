<?
/* Linked list -Linkedlist.php-

   A linked list is a data structure in which the objects are arranged
   in a lineair order. Unlike a array, thought in which the lineair order
   is determined bij array indices, the order is determinded by a
   pointer in each object.

   Algorithm from:
   Introduction to ALGORITHMS
        Thomas H. Cormen
        Charles E. Leiserson
        Ronald L. Rivest
        www-mitpress.mit.edu

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2, or (at your option)
   any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software Foundation,
   Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.

   copyrigth 2002 Email Communications, http://www.emailcommunications.nl/
   written by Bas Jobsen (bas@startpunt.cc)
   Last Change: 2003/02/13
 */




class ListItem
{
    var $key;
    var $v;
    var $t;
    var $ch;
    var $next;
    var $prev;

    function ListItem($key=NULL,$v=NULL,$t=NULL,$ch=NULL)
    {
        $this->key=$key;
        $this->v=$v;
        $this->t=$t;
        $this->ch=$ch;
        $this->next=NULL;
        $this->prev=NULL;
    }
}

class LinkedList
{
    var $head;

    function LinkedList()
    {
        $this->head=NULL;
    }

    function ListInsert(&$x)
    {

        $x->next = &$this->head;
        if(!is_null($this->head))$this->head->prev=&$x;
        $this->head=&$x;
        $this->head->prev=NULL;

    }

    function ListSearch($k)
    {
        $x=&$this->head;
        while(!is_null($x) && $x->key!=$k)
        {
            $x=&$x->next;
        }
        return $x;
    }

    function ListDelete(&$x)
    {
        if (!is_null($x->prev)) $x->prev->next=&$x->next;
        else $this->head=&$x->next;
        if (!is_null($x->next))	$x->next->prev=&$x->prev;
    }

    function Listshow()
    {
        $x=&$this->head;
        $b=1;
        while ($b)
        {
            echo 'key:'.$x->key."\n";
            if(is_null($x->next))$b=0;
            $x=&$x->next;
        }

    }

    function DisplayValues($k)
    {
        $x=&$this->head;
        while(!is_null($x) && $x->key!=$k)
        {
            $x=&$x->next;
        }
        $y=$x->key;
        $z=$x->t;
        $w=$x->v;
        $v=$x->ch;
        echo "n:".$y." t:".$z." v:".$w." ch:".$v."<br>";
        return  $y;
    }


    function ReturnOnValues($k)
    {
        $x=&$this->head;
        while(!is_null($x) && $x->key!=$k)
        {
            $x=&$x->next;
        }
        $On[0]=$x->t;
        $On[1]=$x->v;
        $On[2]=$x->ch;
        $On[3]=$x->key;
        return  $On;
    }

    function formatTimeLen($ts,$length,$timebase)
    {
        $Llength;
        if ($ts==null){$ts=4;}
        $res=floor($length/($timebase*$ts));

        if ($res!=0){
            if ($res<10 && $res<$ts) {$Llength[0]="00".$res; }
            elseif ($res<100 && $res<$ts){$Llength[0]="0".$res; }
            else {$Llength[0]=$res;}
        }

        $ticksPerTakt=$timebase*$ts;

        $rest=$length%$ticksPerTakt;
        $res2=floor($rest/$timebase);

        if ($res2!=0){
            if ($res2<10) {$Llength[1]="0".$res2; }
            else {$Llength[1]=$res2;}

        }

        $rest2=($length-$res*$ticksPerTakt-$res2*$timebase)%($ticksPerTakt);

        if ($rest2!=0)
        {
            if ($rest2<10) {$Llength[2]="00".$rest2; }
            elseif ($rest2<100){$Llength[2]="0".$rest2; }
            else {$Llength[2]=$rest2;}
        }

        //default
        if ($Llength[0]==null){$Llength[0]="000";}
        if ($Llength[1]==null){$Llength[1]="00";}
        if ($Llength[2]==null){$Llength[2]="000";}

        return  $Llength;
    }


    function formatTimeOffs($tss,$On,$timebasee)
    {
        $Offset;
        if ($tss==null){$tss=4;}
        $ticksPerTaktt=$timebasee*$tss;
        $ress=floor($On/$ticksPerTaktt);
        //echo ($ress);echo ("<br>");
        if ($On<$ticksPerTaktt){$Offset[0]="001";}

        if ($ress!=0){
            $tmp=$ress+1;
            if ($ress<9) {$Offset[0]="00".$tmp; }
            elseif ($ress<99){$Offset[0]="0".$tmp; }
            else {$Offset[0]=$ress+1;}
        }

        $restt=$On%$ticksPerTaktt;
        $ress2=floor($restt/$timebasee);

        if ($ress2!=0){
            $tmp2=$ress2+1;
            $Offset[1]="0".$tmp2;
        }

        $restt2=($On-$ress*$ticksPerTaktt-$ress2*$timebasee)%($ticksPerTaktt);

        if ($restt2!=0)
        {
            if ($restt2<10) {$Offset[2]="00".$restt2; }
            elseif ($restt2<100){$Offset[2]="0".$restt2; }
            else {$Offset[2]=$restt2;}
        }

        if ($Offset[1]==null){$Offset[1]="01";}
        if ($Offset[2]==null){$Offset[2]="001";}

        return  $Offset;
    }

    function patternLength($tsss,$t,$timebaseee,$on){

        if ($tsss==null){$tsss=4;}

        $resss=ceil(($t-$on)/($timebaseee*$tsss)); //För antalet takter i en pattern (avrundas uppåt)

        if ($resss<10) {$patternLen="00".$resss.":00:000";}
        elseif ($resss<100){$patternLen="0".$resss.":00:000"; }
        else {$patternLen=$resss.":00:000";}
        return $patternLen;
    }


    function sectionLength($tssss,$tt,$timebaseeee){

        if ($tssss==null){$tssss=4;}

        $ressss=ceil($tt/($timebaseeee*$tssss)); //För antalet takter i en section (avrundas uppåt)
        //$ressss=1+$ressss;
        if ($ressss<10) {$sectionLen="00".$ressss.":00:000";}
        elseif ($ressss<100){$sectionLen="0".$ressss.":00:000";}
        else {$sectionLen=$ressss.":00:000";}
        return $sectionLen;
    }

}
?>
