package com.psm.restup.model;
public class ActionStatus
{
	
    private String table;
    

	public ActionStatus( String table)
	{
        this.table = table;
        
	}

	public ActionStatus()
	{}

	public String getTable()
	{
		return table;
	}
	public void setTable(String table)
	{
		this.table = table;
	}
	
  
	public String toString()
	{
		return " Table : " + table;
					
	}
}
