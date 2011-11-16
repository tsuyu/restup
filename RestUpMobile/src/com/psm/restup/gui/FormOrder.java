package com.psm.restup.gui;

import javax.microedition.lcdui.Command;
import javax.microedition.lcdui.CommandListener;
import javax.microedition.lcdui.Displayable;
import javax.microedition.lcdui.Form;
import javax.microedition.lcdui.TextField;

import com.psm.restup.connector.OrderSender;
import com.psm.restup.login.Login;
import com.psm.restup.midlet.MidletRestUP;
import com.psm.restup.util.CommandBuilder;
import javax.microedition.lcdui.Choice;
import javax.microedition.lcdui.ChoiceGroup;

public class FormOrder extends Form implements CommandListener
{
	//midlet
	private MidletRestUP midlet;
	//previous display
	private Displayable previousDisplay;
	
	//items
     
	private TextField tfItem0;
        private TextField tfItem1;
        private TextField tfItem2;
        private TextField tfItem3;
        private TextField tfItem4;
        private TextField tfItem5;

        //table
        private final ChoiceGroup choiceTable;
        private final ChoiceGroup choiceQty0;
        private final ChoiceGroup choiceQty1;
        private final ChoiceGroup choiceQty2;
        private final ChoiceGroup choiceQty3;
        private final ChoiceGroup choiceQty4;
        private final ChoiceGroup choiceQty5;

	//commands
	private static final Command cmExit = CommandBuilder.getExit();
	private static final Command cmUpload = CommandBuilder.getUpload();
	private static final Command cmBack = CommandBuilder.getBack();
        

	public FormOrder(MidletRestUP midlet, Displayable previousDisplay)
	{
		//call the Form constructor passing the title
		super("Order Form");
		
		this.midlet = midlet;
		this.previousDisplay = previousDisplay;
		
                String tables[] = {"A1", "A2", "A3","A4","A5","B6","B7","B8","B9","B10"};

                choiceTable = new ChoiceGroup(
		"Table : ",
		Choice.POPUP,tables, null);
                
		tfItem0 = new TextField("Item 1 :", "", 4, TextField.ANY);
                tfItem1 = new TextField("Item 2 :", "", 4, TextField.ANY);
                tfItem2 = new TextField("Item 3 :", "", 4, TextField.ANY);
                tfItem3 = new TextField("Item 4 :", "", 4, TextField.ANY);
                tfItem4 = new TextField("Item 5 :", "", 4, TextField.ANY);
                tfItem5 = new TextField("Item 6 :", "", 4, TextField.ANY);

                String options[] = {"","1", "2", "3","4","5","6","7","8","9","10"};
                
                choiceQty0 = new ChoiceGroup(
		"Qty : ",
		Choice.POPUP,options, null);
                choiceQty1 = new ChoiceGroup(
		"Qty : ",
		Choice.POPUP,options, null);
                choiceQty2 = new ChoiceGroup(
		"Qty : ",
		Choice.POPUP,options, null);
                choiceQty3 = new ChoiceGroup(
		"Qty : ",
		Choice.POPUP,options, null);
                choiceQty4 = new ChoiceGroup(
		"Qty : ",
		Choice.POPUP,options, null);
                choiceQty5 = new ChoiceGroup(
		"Qty : ",
		Choice.POPUP,options, null);
                
		//append the items to the form
                append(choiceTable);
                append("\n");
		append(tfItem0);
                append(choiceQty0);
                append(tfItem1);
                append(choiceQty1);
                append(tfItem2);
                append(choiceQty2);
                append(tfItem3);
                append(choiceQty3);
                append(tfItem4);
                append(choiceQty4);
                append(tfItem5);
                append(choiceQty5);

		//add the commands to the form
		addCommand(cmExit);
		addCommand(cmUpload);
		addCommand(cmBack);
		
		//set the command listener
		setCommandListener(this);	
	}

	//called when a command is selected
	public void commandAction(Command c, Displayable d)
	{
		if(c == cmExit)
		{
			midlet.shutDownApp(false);
		}
		else if(c == cmBack)
		{
			midlet.setDisplay(previousDisplay);
		}
		else if(c == cmUpload)
		{
			//retrieve login data
			Login login = new Login();
			//userid
			String userid = login.getUserid();
			//password
			String password = login.getPassword();
			//title
                        int i = choiceTable.getSelectedIndex();
                        String table = choiceTable.getString(i);
                      
			String item0 = tfItem0.getString();
                        String item1 = tfItem1.getString();
                        String item2 = tfItem2.getString();
                        String item3 = tfItem3.getString();
                        String item4 = tfItem4.getString();
                        String item5 = tfItem5.getString();

			
                        int j = choiceQty0.getSelectedIndex();
                        String qty0 = choiceQty0.getString(j);
                        int k = choiceQty1.getSelectedIndex();
                        String qty1 = choiceQty1.getString(k);
                        int l = choiceQty2.getSelectedIndex();
                        String qty2 = choiceQty2.getString(l);
                        int m = choiceQty3.getSelectedIndex();
                        String qty3 = choiceQty3.getString(m);
                        int n = choiceQty4.getSelectedIndex();
                        String qty4 = choiceQty4.getString(n);
                        int o = choiceQty5.getSelectedIndex();
                        String qty5 = choiceQty5.getString(o);
                          
                        

			//retrieve the post
			OrderSender pr = new OrderSender(midlet, this, 
                                userid, password, table, item0, item1, item2, item3,
                                        item4, item5, qty0, qty1, qty2, qty3, qty4 ,qty5);
			pr.start();
		}
		
	}

}
