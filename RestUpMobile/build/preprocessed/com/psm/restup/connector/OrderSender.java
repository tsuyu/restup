package com.psm.restup.connector;

import java.io.IOException;
import java.io.InputStream;

import javax.microedition.io.Connector;
import javax.microedition.io.HttpConnection;
import javax.microedition.lcdui.Displayable;

import com.psm.restup.midlet.MidletRestUP;

public class OrderSender implements Runnable
{

	private String userid;
	private String password;
        private String table;
	private String item0;
        private String item1;
        private String item2;
        private String item3;
        private String item4;
        private String item5;
	private String qty0;
        private String qty1;
        private String qty2;
        private String qty3;
        private String qty4;
        private String qty5;
	private String URL = "http://localhost:8083/RestUPWeb/mobile/order_sender.php";
	private MidletRestUP midlet;
	private Displayable previousDisplay;
	private String result;
	
	public OrderSender(MidletRestUP midlet, Displayable previousDisplay,
			 String userid, String password, String table, String item0, String item1,
                        String item2, String item3, String item4,String item5,
                        String qty0,String qty1,String qty2,String qty3,String qty4,String qty5)
	{
		this.midlet = midlet;
		this.previousDisplay = previousDisplay;
		this.userid = userid;
		this.password = password;
                this.table = table;

		this.item0 = item0;
                this.item1 = item1;
                this.item2 = item2;
                this.item3 = item3;
                this.item4 = item4;
                this.item5 = item5;

                
		this.qty0 = qty0;
                this.qty1 = qty1;
                this.qty2 = qty2;
                this.qty3 = qty3;
                this.qty4 = qty4;
                this.qty5 = qty5;
	}

	public void run()
	{
		try
		{
			sendPost();
		}
		catch (Exception e)
		{
			e.printStackTrace();
			System.err.println("Error: " + e.toString());
			networkError(e.toString());
		}
	}

	public void start()
	{
		Thread t = new Thread(this);
		try
		{
			t.start();
		}
		catch (Exception e)
		{
			System.err.println("Error: " + e.toString());
			networkError(e.toString());
		}
	}

	private void sendPost() throws IOException
	{
		InputStream is = null;
		StringBuffer sb = null;
		HttpConnection http = null;
		try
		{
			// append the query string onto the URL
			URL += "?userid=" + userid + "&password=" + password + "&table=" + table + "&item0=" + item0
                                + "&item1=" + item1 + "&item2=" + item2 + "&item3=" + item3 + "&item4=" + item4
                                + "&item5=" + item5 + "&qty0=" + qty0 + "&qty1=" + qty1 + "&qty2=" + qty2 + "&qty3=" + qty3
                                + "&qty4=" + qty4 + "&qty5=" + qty5;
			// replace not allowed char in the URL
			URL = EncodeURL(URL);
			// establish the connection
			http = (HttpConnection) Connector.open(URL);
			// set the request method as GET
			http.setRequestMethod(HttpConnection.GET);
			// server response
			if (http.getResponseCode() == HttpConnection.HTTP_OK)
			{
				sb = new StringBuffer();
				int ch;
				is = http.openInputStream();
				while ((ch = is.read()) != -1)
					sb.append((char) ch);
			}
			else
			{
				System.out.println("Network error");
				networkError();
			}
		}
		catch (Exception e)
		{
			System.err.println("Error: " + e.toString());
			networkError(e.toString());
		}
		finally
		{
			if (is != null)
				is.close();
			if (sb != null)
				result = sb.toString();
			else
				networkError();
			if (http != null)
				http.close();
		}

		if (result != "")
		{
			System.out.println(result);
			midlet.showInfo(result, getCurrentDisplay());
		}
		else
		{
			networkError();
		}

	}

	private Displayable getCurrentDisplay()
	{
		// get the current display
		Displayable d = midlet.getCurrentDisplay();
		// if it is an Alert set the next display as the previous one
		if (d.getClass().getName().equals("javax.microedition.lcdui.Alert"))
		{
			d = previousDisplay;
		}
		return d;
	}

	private String EncodeURL(String URL)
	{
		URL = replace(URL, '�', "%E0");
		URL = replace(URL, '�', "%E8");
		URL = replace(URL, '�', "%E9");
		URL = replace(URL, '�', "%EC");
		URL = replace(URL, '�', "%F2");
		URL = replace(URL, '�', "%F9");
		URL = replace(URL, '$', "%24");
		URL = replace(URL, '#', "%23");
		URL = replace(URL, '�', "%A3");
		URL = replace(URL, '@', "%40");
		URL = replace(URL, '\'', "%27");
		URL = replace(URL, ' ', "%20");

		return URL;
	}

	private String replace(String source, char oldChar, String dest)
	{
		String ret = "";
		for (int i = 0; i < source.length(); i++)
		{
			if (source.charAt(i) != oldChar)
				ret += source.charAt(i);
			else
				ret += dest;
		}
		return ret;
	}

	private void networkError()
	{
		midlet.showInfo("Network error, try later", getCurrentDisplay());
	}
	private void networkError(String msg)
	{
		midlet.showInfo(msg, getCurrentDisplay());
	}
}
