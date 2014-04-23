import java.util.*;


public class CMain {

	/**
	 * @param args
	 */
   static List <String>  kisaltma = new ArrayList<String>();
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
	String cumle = "Ben 2006 yýlýnda Yýldýz Teknik Üniversitesi Bilgisayar Mühendisliðinden" +
			" mezun oldum. Ayný yýl YTÜ de yüksek lisansa baþladým. Þu an doktoramý" +
			" bitirmiþ durumdayým. Ýmzamý atarken Dr. Ali Savaþ diye yazýyorum. " +
			"Doktora sonrasý New York’a gittim. NY üniversitesinden kabul aldým. " +
			"Bundan sonra TC vatandaþý olduðum halde USA ‘de yaþayacaðým." ;
	
	
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
	   
	   System.out.println("Kýsaltma : "+i);
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
