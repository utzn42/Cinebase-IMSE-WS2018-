package Extras;

public class SeatCreator {
    public StringBuilder sb = new StringBuilder();

    public SeatCreator() {
        for (int i = 1; i < 9; ++i) {
            for (int j = 1; j < 11; ++j) {
                for (int k = 1; k < 16; ++k) {
                    sb.append("INSERT INTO seat(seat_id, hall_id, seat_nr, row_nr) VALUES (null, " + i + ", " + j + ", " + k + ");\n");
                }
            }
        }
    }
}
