package com.psm.restup.util;


import com.psm.restup.model.ActionStatus;
import java.util.Vector;


public class ActionStatusParser
{
	//String used to separate the items
	private static final String SPLITTER = "|";
	
	//post in the raw format which is: author|title|text
  private String rawStatus = "";
  //index pointer used by the parser
  private int index;
  
  public ActionStatusParser(String rawStatus)
  {
  	this.rawStatus = rawStatus;
  	this.index = 0;
  }
	
	public ActionStatus parse()
	{
		//check if the argument is valid
		if(rawStatus.length() == 0)
		{
			throw new IllegalArgumentException("Empty String passed");
		}
		//extract the 4 items of the post
		String[] items = extractItems();
		//if the items are != 4 then an exception is thrown
		if(items.length == 1)
		{
			//the server returned an error message which is in items[0]
			throw new IllegalStateException(items[0]);
		}
		if(items.length != 3)
		{
			//the post returned is not in the format author|date|title|text
			//throw new IllegalStateException("The post downloaded is in a wrong format");
		}
		//return a post built up by the items extracted
		return new ActionStatus(items[0]);
	}

	//extract the itms of the post and put them in a String array
	private String[] extractItems()
	{
		Vector v = new Vector();
		//find the first occurrence of the SPLITTER
		int endIndex = rawStatus.indexOf(SPLITTER, index);
		String item = "";
		//extract the items until the end of the last SPLITTER found in the rawPost string
		while(endIndex != -1)
		{
			item = rawStatus.substring(index, endIndex);
			index = endIndex + 1;
			endIndex = rawStatus.indexOf(SPLITTER, index);
			v.addElement(item);
		}
		//extract the rest of the rawPost (the text item)
		item = rawStatus.substring(index);
		v.addElement(item);
		String[] ret = new String[v.size()];
		//copy the content of the Vector in a string array
		v.copyInto(ret);
		return ret;
	}

}