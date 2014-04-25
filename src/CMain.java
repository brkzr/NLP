import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class CMain{

	/**
	 * @param args
	 * 
	 */
	static List<String>	kisaltma	= new ArrayList<String>();

	public static void main(String[] args) {
		// TODO Auto-generated method stub

		String cumle = "Ben 2006 yılında Yıldız Teknik Üniversitesi Bilgisayar Mühendisliğinden" + " mezun oldum. Aynı yol YTÜ de yüksek lisansa başladım. şu an doktoramı" + " bitirmiş durumdayım. İmzamı atarken Dr. Ali Savaş diye yazıyorum. " + "Doktora sonrası New York'a gittim. NY Üniversitesinden kabul aldım. " + "Bundan sonra TC vatandaşı olduğum halde USA'de yaşayacağım.";

		//nokta virgül ayraç ... ve boşluk a göre parçalama işlemi (USA'de örneği)
		String delimiters = "[ .,;']+";
		String[] parts = cumle.split(delimiters);

		//String[] parts = cumle.split(" ");
		System.out.println("Uzunluk : " + parts.length);
		int[] isCapital = new int[parts.length];

		Arrays.fill(isCapital, 0);
		findCapital(parts, isCapital);
		for (int i = 0; i < parts.length; i++) {
			System.out.println("Kelime : " + parts[i] + " - Kontrol : " + isCapital[i]);
		}

		isKisaltma(parts, isCapital);
		for (String i : kisaltma) {

			System.out.println("Kısaltma : " + i);
		}

		for (String sentence : kisaltma) {
			findComplateSenstenceForAbbreviation(cumle, sentence);
		}

	}//END_OF_MAIN

	public static void findCapital(String[] sentence,int[] index) {

		int i = 0;
		for (String string : sentence) {
			if (Character.isUpperCase(string.charAt(0))) {
				index[i] = 1;
			}

			i++;
		}

	}

	public static void isKisaltma(String[] sentence,int[] index) {

		int i = 0;
		boolean control = true;
		for (String string : sentence) {
			if (index[i] == 1) {
				for (int j = 0; j < string.length(); j++) {
					if (!Character.isUpperCase(string.charAt(j))) {
						control = false;
					}
				}
				if (control) {
					kisaltma.add(string);
				}
				control = true;

			}

			i++;
		}

	}

	public static void findComplateSenstenceForAbbreviation(String text,String abbreviation) {

		String regex = "[ ]+";
		for (int i = 0; i < abbreviation.length(); i++) {
			if (i == 0) {
				regex += "([" + abbreviation.charAt(i) + "][a-z|ı|ü|ş|ç|ğ|ö]*)";
			} else if (i == abbreviation.length() - 1) {
				regex += "( [" + abbreviation.charAt(i) + "][a-z|ı|ü|ş|ç|ğ|ö]*)";
			} else {
				regex += "(( [a-z|ı|ü|ş|ç|ğ|ö]*)* [" + abbreviation.charAt(i) + "][a-z|ı|ü|ş|ç|ğ|ö]*)?";
			}
		}
		//System.out.println("REGEX => " + regex);
		Pattern pattern = Pattern.compile(regex);
		Matcher matcher = pattern.matcher(text);
		while (matcher.find()) {
			System.out.println("O.K. For : " + abbreviation + " => " + matcher.group());
		}
	}

}
