using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ParkingProba
{
    public class Transaction
    {
        private User user;
        private Int32 amount;
        private DateTime dateTime;

        public Transaction(User user, int amount)
        {
            this.user = user;
            this.amount = amount;
        }
    }
}
