package ms3kinoUI;

import Extras.Window;

import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class MainScreen extends Window {
    private JButton importAllFromCinebaseButton;
    private JPanel mainPanel;
    private JButton manualDataEntryButton;

    public MainScreen() {
        run(mainPanel);
        manualDataEntryButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                frame.setVisible(false);
                new DataEntryChooser().frame.setVisible(true);
            }
        });
    }
}
