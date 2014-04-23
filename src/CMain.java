import java.util.*;


public class CMain {

	/**
	 * @param args
	 */
   static List <String>  kisaltma = new ArrayList<String>();
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
	String cumle = "Ben 2006 y�l�nda Y�ld�z Teknik �niversitesi Bilgisayar M�hendisli�inden" +
			" mezun oldum. Ayn� y�l YT� de y�ksek lisansa ba�lad�m. �u an doktoram�" +
			" bitirmi� durumday�m. �mzam� atarken Dr. Ali Sava� diye yaz�yorum. " +
			"Doktora sonras� New York�a gittim. NY �niversitesinden kabul ald�m. " +
			"Bundan sonra TC vatanda�� oldu�um halde USA �de ya�ayaca��m." ;
	
	
	String[] parts = cumle.split(" ");
	System.out.println("Uzunluk : "+parts.length);
	int [] isCapital = new int[parts.length];
	
    Arrays.fill(isCapital,0);
    findCapital(parts, isCapital);
    for(int i=0;i<parts.length;i++){
    	System.out.println("Kelime : "+parts[i]+" - Kontrol : "+isCapital[i] );
    }
    
   isKisaltma(parts, isCapital);
   for (String i : kisaltma) {
	   
	   System.out.println("K�saltma : "+i);
}
    
	}
	
public static void findCapital(String[] sentence,int[] index){
	
		int i=0;
		for (String string : sentence) {
			if(Character.isUpperCase(string.charAt(0))){
			   	index[i]=1;
			}
			
			i++;
		}
	
		
		
	}


	public static void isKisaltma(String[] sentence,int[] index){
		
		int i=0;
		boolean control=true;
		for (String string : sentence) {
			if(index[i]==1){
				for(int j=0;j<string.length();j++){
	     			if(!Character.isUpperCase(string.charAt(j))){
	    			   	control=false;
	    			}
	     		}
	     		if(control){
	     		kisaltma.add(string);
	     		}
	     		control = true;
				
			}
     		
			
			i++;
		}
		
	}

}
