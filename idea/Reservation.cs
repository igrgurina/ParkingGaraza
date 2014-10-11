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
        /// TODO: Raise an event when TimeLeft is 0. -- transaction
        /// </summary>
        internal TimeSpan TimeLeft { get { return EndDateTime - DateTime.UtcNow; } }

        public Reservation(User user, ParkingSpot parkingSpot, ReservationType reservationType, TimeSpan trajanje, DateTime? startTime = null, TimeSpan? period = null)
        {
            User = user;
            ParkingSpot = parkingSpot;

            StartDateTime = startTime ?? DateTime.UtcNow;
            EndDateTime = StartDateTime + trajanje.Duration();

            Type = reservationType;
            // TODO: throw error if conditions for reservation types and their duration and periods weren't met
            switch (reservationType)
            {
                case ReservationType.Jednokratno:
                    //  jednokratno za vremenski period kraći od 24 sata i to mora obaviti barem 6h unaprijed
                    if (trajanje.TotalHours > 24.0 || StartDateTime < DateTime.UtcNow.AddHours(6))
                        throw new Exception();
                    //new Transaction();
                    break;
                case ReservationType.Ponavljajuće:
                    // ponavljajuća rezervacija koja mora trajati najmanje 1h i ponavljati se barem 
                    // jednom tjedno tijekom mjesec dana
                    if(trajanje.Minutes < 60 || period.Value.TotalDays > 7)
                        throw new Exception();
                    break;
                case ReservationType.Trajno:
                    break;
                default:
                    throw new ArgumentOutOfRangeException("reservationType");
            }
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
