package com.psm.restup.util;
import javax.microedition.lcdui.Command;

public class CommandBuilder
{
	public static Command getSelect()
	{
		return new Command("Select", Command.OK, 1);
	}

	public static Command getExit()
	{
		return new Command("Exit", Command.EXIT, 1);
	}

	public static Command getBack()
	{
		return new Command("Back", Command.BACK, 1);
	}

	public static Command getMain()
	{
		return new Command("Main", Command.ITEM, 1);
	}

	public static Command getDownload()
	{
		return new Command("Download", Command.ITEM, 1);
	}

	public static Command getUpload()
	{
		return new Command("Upload", Command.ITEM, 1);
	}

	public static Command getStoreLogin()
	{
		return new Command("Store", Command.ITEM, 1);
	}
}