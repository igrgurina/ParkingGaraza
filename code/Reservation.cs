using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ParkingProba
{
    public class Reservation
    {
        /// <summary>
        /// Discount for registered users.
        /// </summary>
        public static Double Discount = 0.25;

        public User User;
        public ParkingSpot ParkingSpot;
        public DateTime StartDateTime;
        public DateTime EndDateTime;
        public ReservationType Type;

        /// <summary>
        /// TODO: Raise an event when TimeLeft is 0.
        /// </summary>
        internal TimeSpan TimeLeft
        {
            get
            {
                return EndDateTime - DateTime.UtcNow;
            }
        }

        public Reservation(User user, ParkingSpot parkingSpot, ReservationType reservationType, TimeSpan timeSpan, TimeSpan period)
        {
            User = user;
            ParkingSpot = parkingSpot;

            StartDateTime = DateTime.UtcNow;
            EndDateTime = StartDateTime + timeSpan.Duration();

            Type = reservationType;
            // TODO: throw error if conditions for reservation types and their duration and periods weren't met
        }

        /// <summary>
        /// Calculate reservation price based on various parameters.
        /// </summary>
        /// <returns></returns>
        private Double Price()
        {
            return 0;
        }
    }
}
